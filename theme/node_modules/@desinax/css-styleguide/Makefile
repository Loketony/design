#
# A Makefile
#

# ---------------------------------------------------------------------------
#
# General setup
#

# Detect OS
OS = $(shell uname -s)

# Defaults
ECHO = echo

# Make adjustments based on OS
# http://stackoverflow.com/questions/3466166/how-to-check-if-running-in-cygwin-mac-or-linux/27776822#27776822
ifneq (, $(findstring CYGWIN, $(OS)))
	ECHO = /bin/echo -e
endif

# Colors and helptext
NO_COLOR	= \033[0m
ACTION		= \033[32;01m
OK_COLOR	= \033[32;01m
ERROR_COLOR	= \033[31;01m
WARN_COLOR	= \033[33;01m

# Which makefile am I in?
WHERE-AM-I = $(CURDIR)/$(word $(words $(MAKEFILE_LIST)),$(MAKEFILE_LIST))
THIS_MAKEFILE := $(call WHERE-AM-I)

# Echo some nice helptext based on the target comment
HELPTEXT = $(ECHO) "$(ACTION)--->" `egrep "^\# target: $(1) " $(THIS_MAKEFILE) | sed "s/\# target: $(1)[ ]*-[ ]* / /g"` "$(NO_COLOR)"

# target: help               - Displays help.
.PHONY:  help
help:
	@$(call HELPTEXT,$@)
	@$(ECHO) "Usage:"
	@$(ECHO) " make [target] ..."
	@$(ECHO) "target:"
	@egrep "^# target:" $(THIS_MAKEFILE) | sed 's/# target: / /g'



# ---------------------------------------------------------------------------
#
# Specifics
#

# Add local bin path for test tools
STYLELINT 	:= node_modules/.bin/stylelint
JSONLINT   	:= node_modules/.bin/jsonlint

# Find sources
JSON_SOURCES 	:= $(wildcard *.json) $(wildcard .*.json)
CSS_SOURCES 	:= $(wildcard test/css/*.css)



# target: prepare            - Prepare for tests and build
.PHONY:  prepare
prepare:
	@$(call HELPTEXT,$@)
	#[ -d .bin ] || mkdir .bin
	#[ -d build ] || mkdir build
	#rm -rf build/*



# target: clean              - Removes generated files and directories.
.PHONY:  clean
clean:
	@$(call HELPTEXT,$@)
	#rm -rf build



# target: clean-all          - Removes generated files and directories.
.PHONY:  clean-all
clean-all:
	@$(call HELPTEXT,$@)
	rm -rf node_modules



# target: check              - Check version of installed tools.
.PHONY:  check
check:
	@$(call HELPTEXT,$@)
	node --version
	npm --version
	npm list stylelint jsonlint
	$(STYLELINT) --version
	-$(JSONLINT) --version



# target: test               - Run all tests.
.PHONY:  test
test: jsonlint stylelint
	@$(call HELPTEXT,$@)
	#npm validate config file



# target: install            - Install all tools
.PHONY:  install
install: prepare
	@$(call HELPTEXT,$@)
	npm install 


# target: update             - Update the codebase and tools.
.PHONY:  update
update:
	@$(call HELPTEXT,$@)
	npm update



# target: tag-prepare        - Prepare to tag new version.
.PHONY: tag-prepare
tag-prepare:
	@$(call HELPTEXT,$@)
	grep "^v." REVISION.md | head -1
	grep version package.json
	git tag
	git status
	#gps && gps --tags
	#npm publish



# ---------------------------------------------------------------------------
#
# Npm tools
#

# target: jsonlint           - Validate JSON-files.
.PHONY: jsonlint
jsonlint:
		@$(call HELPTEXT,$@)
		$(JSONLINT) --quiet $(JSON_SOURCES)



# target: stylelint          - Validate using stylelint.
.PHONY: stylelint
stylelint:
	@$(call HELPTEXT,$@)
	$(STYLELINT) $(CSS_SOURCES)
