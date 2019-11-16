#!/usr/bin/env make
#
# A Desinax Theme Module.
# See organisation on GitHub: https://github.com/desinax

# ------------------------------------------------------------------------
#
# General stuff, reusable for all Makefiles.
#

# Detect OS
OS = $(shell uname -s)

# Defaults
ECHO = echo

# Make adjustments based on OS
ifneq (, $(findstring CYGWIN, $(OS)))
	ECHO = /bin/echo -e
endif

# Colors and helptext
NO_COLOR	= \033[0m
ACTION		= \033[32;01m
OK_COLOR	= \033[32;01m
ERROR_COLOR	= \033[31;01m
WARN_COLOR	= \033[33;01m

# Print out colored action message
ACTION_MESSAGE = $(ECHO) "$(ACTION)---> $(1)$(NO_COLOR)"

# Which makefile am I in?
WHERE-AM-I = "$(CURDIR)/$(word $(words $(MAKEFILE_LIST)),$(MAKEFILE_LIST))"
THIS_MAKEFILE := $(call WHERE-AM-I)

# Echo some nice helptext based on the target comment
HELPTEXT = $(call ACTION_MESSAGE, $(shell egrep "^\# target: $(1) " $(THIS_MAKEFILE) | sed "s/\# target: $(1)[ ]*-[ ]* / /g"))

# Check version  and path to command and display on one line
CHECK_VERSION = printf "%-15s %-10s %s\n" "$(shell basename $(1))" "`$(1) --version $(2)`" "`which $(1)`"

# Get current working directory, it may not exist as environment variable.
PWD = $(shell pwd)



# target: help                    - Displays help.
.PHONY:  help
help:
	@$(call HELPTEXT,$@)
	@sed '/^$$/q' $(THIS_MAKEFILE) | tail +3 | sed 's/#\s*//g'
	@$(ECHO) "Usage:"
	@$(ECHO) " make [target] ..."
	@$(ECHO) "target:"
	@egrep "^# target:" $(THIS_MAKEFILE) | sed 's/# target: / /g'



# target: tag-prepare             - Prepare to tag new version.
.PHONY: tag-prepare
tag-prepare:
	@$(call HELPTEXT,$@)
	grep "^v." REVISION.md | head -1
	[ ! -f package.json ] || grep version package.json
	git tag
	git status
	#gps && gps --tags
	#npm publish



# ------------------------------------------------------------------------
#
# Specifics for this project.
#

# Add local bin path for test tools
LESSC     = node_modules/.bin/lessc
STYLELINT = node_modules/.bin/stylelint

LESS_INCLUDE_PATH = src/less

# Find sources
JSON_SOURCES 	:= $(wildcard *.json) $(wildcard .*.json)
CSS_SOURCES 	:= $(wildcard build/*.css)
LESS_SOURCES 	:= $(wildcard src/less/*.less)
SASS_SOURCES 	:= $(wildcard src/sass/*.sass)
JS_SOURCES 		:= $(wildcard src/js/*.js)

LESS_BUILD		:= $(LESS_SOURCES:src/less/%.less=build/less/%.css)
LESS_MIN_BUILD	:= $(LESS_SOURCES:src/less/%.less=build/less/%.min.css)

LESS_LINT_BUILD	:= $(LESS_SOURCES:src/less/%.less=build/less-lint/%.lesslint)
LESS_CSS_LINT_BUILD	:= $(LESS_BUILD:build/less/%.css=build/less-lint/%.csslint)



# ------------------------------------------------------------------------
#
# Basic rules.
#
# target: prepare                 - Empty and prepare the build directory.
.PHONY: prepare
prepare: 
	@$(call HELPTEXT,$@)
	rm -rf build/*
	install -d build/less build/less-lint build/css build/lint



# target: build                   - Build the stylesheets.
.PHONY: build
build: prepare less less-lint
	@$(call HELPTEXT,$@)



# target: clean                   - Clean from generated build files.
.PHONY: clean
clean: 
	@$(call HELPTEXT,$@)
	rm -rf build



# target: clean-all               - Clean all installed utilities.
.PHONY: clean-all
clean-all: clean
	@$(call HELPTEXT,$@)
	rm -rf node_modules



# target: install                 - Install modules and dev environment.
.PHONY: install
install: npm-install
	@$(call HELPTEXT,$@)



# target: check                   - Check versions of tools.
.PHONY: check
check:
	@$(call HELPTEXT,$@)
	@$(call CHECK_VERSION, $(LESSC))
	@$(call CHECK_VERSION, $(ESLINT))
	npm list --depth=0



# target: update                  - Update codebase.
.PHONY: update
update: npm-update
	@$(call HELPTEXT,$@)



# target: upgrade                 - Upgrade codebase.
.PHONY: upgrade
upgrade: styleguide-install
	@$(call HELPTEXT,$@)



# target: test                    - Execute all tests.
.PHONY: test
test: less-lint
	@$(call HELPTEXT,$@)



# ------------------------------------------------------------------------
#
# Validation according to CSS-styleguide.
#
# target: styleguide-install      - Install styleguide validation files.
.PHONY: styleguide-install
styleguide-install:
	@$(call HELPTEXT,$@)
	rsync -av node_modules/css-styleguide/.stylelintrc.json .




# ------------------------------------------------------------------------
#
# LESS.
#
# target: less                    - Compile the LESS stylesheet(s).
.PHONY: less
less: prepare $(LESS_BUILD) $(LESS_MIN_BUILD)
	@$(call HELPTEXT,$@)

build/less/%.css: src/less/%.less
	@$(call ACTION_MESSAGE, $< -> $@)
	$(LESSC) --include-path=$(LESS_INCLUDE_PATH) --source-map $< $@

build/less/%.min.css: src/less/%.less
	@$(call ACTION_MESSAGE, $< -> $@)
	$(LESSC) --include-path=$(LESS_INCLUDE_PATH) --source-map --clean-css $< $@



# target: less-lint               - Lint the LESS stylesheet(s).
.PHONY: less-lint
less-lint: less $(LESS_LINT_BUILD) $(LESS_CSS_LINT_BUILD)
	@$(call HELPTEXT,$@)

build/less-lint/%.lesslint: src/less/%.less
	@$(call ACTION_MESSAGE, $< -> $@)
	$(LESSC) --include-path=$(LESS_INCLUDE_PATH) --lint $< > $@ 
	- $(STYLELINT) $< > $@.stylelint

build/less-lint/%.csslint: build/less/%.css
	@$(call ACTION_MESSAGE, $< -> $@)
	- $(STYLELINT) $@ > $@



# ------------------------------------------------------------------------
#
# JavaScript
#
.PHONY: js-cs js-lint 
	
# target: js-minify          - Minify JavaScript files to min.js
js-minify: prepare-build
	@$(call HELPTEXT,$@)
	@for file in $(JS_FILES); do \
		filename=$$(basename "$$file"); \
		extension="$${filename##*.}"; \
		filename="$${filename%%.*}"; \
		target="build/js/$${filename}.min.$${extension}"; \
		$(ECHO) "==> Minifying $$file > $$target"; \
		$(JS_MINIFY) $(JS_MINIFY_OPTIONS) --output $$target $$file; \
		$(ECHO) "==> Installing to htdocs/js/$$target"; \
		cp $$target $$file htdocs/js; \
	done

	

#%.min.js: %.js
#	@$(ECHO) '==> Minifying $<'
#	$(JS_MINIFY) $(JS_MINIFY_OPTIONS) --output $@ $<



# target: js-cs              - Check codestyle in javascript files
# js-cs:
# 	@$(call HELPTEXT,$@)
# 	@for file in $(JS_FILES); do \
# 		$(ECHO) "==> JavaScript codestyle $$file"; \
# 		$(JS_CODESTYLE) $(JS_CODESTYLE_OPTIONS) $$file; \
# 	done



# target: js-lint            - Lint javascript files
js-lint:
	@$(call HELPTEXT,$@)
	@for file in $(JS_FILES); do \
		$(ECHO) "==> JavaScript lint $$file"; \
		$(JS_LINT) $(JS_LINT_OPTIONS) $$file; \
	done



# ------------------------------------------------------------------------
#
# NPM.
#
# target: npm-install             - Install npm from package.json.
.PHONY: npm-install
npm-install: 
	@$(call HELPTEXT,$@)
	npm install



# target: npm-update              - Update npm using package.json.
.PHONY: npm-update
npm-update: 
	@$(call HELPTEXT,$@)
	npm update



# target: npm-outdated            - Check for outdated packages.
.PHONY: npm-outdated
npm-outdated: 
	@$(call HELPTEXT,$@)
	npm outdated --depth=0
