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

# Path to source and build libs
BUILD = build
BUILD_LESS = $(BUILD)/less
HTDOCS = htdocs/css
SRC_LESS   = src/less

# LESS files and their built respectives.
LESS_SOURCES = $(wildcard $(SRC_LESS)/*.less)
LESS_CSS = $(LESS_SOURCES:$(SRC_LESS)/%.less=$(BUILD_LESS)/css/%.css)
LESS_MIN_CSS = $(LESS_SOURCES:$(SRC_LESS)/%.less=$(BUILD_LESS)/css/%.min.css)
LESS_LINT 	 = $(LESS_SOURCES:$(SRC_LESS)/%.less=$(BUILD_LESS)/lint/%.less)


# JSON_SOURCES 	:= $(wildcard *.json) $(wildcard .*.json)
# CSS_SOURCES 	:= $(wildcard build/*.css)
# SASS_SOURCES 	:= $(wildcard src/sass/*.sass)
# JS_SOURCES 	:= $(wildcard src/js/*.js)



# ------------------------------------------------------------------------
#
# Basic rules.
#
# target: prepare                 - Prepare the build directory.
.PHONY: prepare
prepare: 
	@$(call HELPTEXT,$@)
	@[ -d $(BUILD_LESS)/css ] || install -d $(BUILD_LESS)/css
	@[ -d $(BUILD_LESS)/lint ] || install -d $(BUILD_LESS)/lint



# target: build                   - Build the stylesheets.
.PHONY: build
build: prepare less
	@$(call HELPTEXT,$@)



# target: clean                   - Clean from generated build files.
.PHONY: clean
clean: 
	@$(call HELPTEXT,$@)
	rm -rf $(BUILD)



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
update: npm-update styleguide-update
	@$(call HELPTEXT,$@)



# target: upgrade                 - Upgrade codebase.
.PHONY: upgrade
upgrade: npm-upgrade styleguide-update
	@$(call HELPTEXT,$@)



# target: test                    - Execute all tests.
.PHONY: test
test: less-lint
	@$(call HELPTEXT,$@)



# ------------------------------------------------------------------------
#
# Validation according to CSS-styleguide.
#
# target: styleguide-update       - Update styleguide validation files.
.PHONY: styleguide-update
styleguide-update:
	@$(call HELPTEXT,$@)
	rsync -av node_modules/@desinax/css-styleguide/.stylelintrc.json .




# ------------------------------------------------------------------------
#
# LESS.
#
# target: less                    - Compile the LESS stylesheet(s).
less: prepare less-css less-min-css
	@$(call HELPTEXT,$@)
	rsync -a --delete $(BUILD_LESS)/css/ $(HTDOCS)/less/

less-css: $(LESS_CSS)
less-min-css: $(LESS_MIN_CSS)
less-lint: $(LESS_LINT)

$(BUILD_LESS)/css/%.css: $(SRC_LESS)/%.less
	@$(call ACTION_MESSAGE,$< -> $@)
	$(LESSC) --include-path=$(SRC_LESS) $< $@

$(BUILD_LESS)/css/%.min.css: $(SRC_LESS)/%.less
	@$(call ACTION_MESSAGE,$< -> $@)
	$(LESSC) --include-path=$(SRC_LESS) --clean-css $< $@

$(BUILD_LESS)/lint/%.less: $(SRC_LESS)/%.less
	@$(call ACTION_MESSAGE,$< -> $@)
	$(LESSC) --include-path=$(SRC_LESS) --lint $< $@



# ------------------------------------------------------------------------
#
# SCSS.
#



# ------------------------------------------------------------------------
#
# CSS.
# @TODO Clean up this rule, is it active?
#
# target: lint-css                - Lint the CSS stylesheet(s).
.PHONY: lint-css
lint-css: less
	@$(call HELPTEXT,$@)
	$(LESSC) --include-path=$(SRC_LESS) --lint $(SRC_LESS) > build/lint/style.less
	- $(ESLINT) build/css/style.css > build/lint/style.css
	ls -l build/lint/



# ------------------------------------------------------------------------
#
# JS.
#



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



# target: npm-upgrade             - Upgrade npm using package.json.
.PHONY: npm-upgrade
npm-upgrade: 
	@$(call HELPTEXT,$@)
	npm upgrade



# target: npm-outdated            - Check for outdated packages.
.PHONY: npm-outdated
npm-outdated: 
	@$(call HELPTEXT,$@)
	npm outdated --depth=0
