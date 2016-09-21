#!/usr/bin/env bash

# Скрипт для создания скелета юнит-теста
#
# TODO: Реализовать добавление док-коммента @group
# TODO: Реализовать добавление алиаса для тестируемого класса

readonly CLASSES_DIR='/home/alex/api/_modules/project/api/_lib'
readonly UNIT_TESTS_DIR='/home/alex/api/tests'
readonly CLASS_EXTENSION='.php'
readonly VERSION='0.0.3'
readonly CURRENT_DIR=$(pwd)

usage_help() {
	print_version
	cat <<EOL
Usage: $0 [OPTION...] <Class name>

Options:
  -v, --version              Show script version
  -h, --help                 Show this help message
  -d, --debug                Run script in debug mode

EOL
	exit 2;
}

print_version() {
	cat <<EOL
create-unit-test ${VERSION} by Yancharuk Alexander

EOL
}

# function for debug messages
debug() {
	[ ! -z ${DEBUG} ] && printf "[$(date --rfc-3339=seconds)]: \033[0;32mDEBUG:\033[0m $@\n"
}

# Function for error
err() {
	print_version
	printf "[$(date --rfc-3339=seconds)]: \033[0;31mERROR:\033[0m $@\n" >&2
}

check_dependencies() {
	debug "Check phpunit-skelgen"
	command -v phpunit-skelgen >/dev/null 2>&1
	if [ $? -ne 0 ]; then
		err "phpunit-skelgen not found"
		exit 1
	fi

	debug "Check sed"
	command -v sed >/dev/null 2>&1
	if [ $? -ne 0 ]; then
		err "sed utility not found"
		exit 1
	fi

	debug "Check find"
	command -v find >/dev/null 2>&1
	if [ $? -ne 0 ]; then
		err "find utility not found"
		exit 1
	fi
}

create_test_dir() {
	debug "Trying to create test dir"

	mkdir -p "${UNIT_TEST_DIR}"

	if [ $? -ne 0 ]; then
		err "Unable to create unit-test dir"
		exit 1
	else
		debug "Success!"
	fi
}

debug "Parse options"
while true; do
	case $1 in
		-h | --help) debug "Found '${1}' option"
			usage_help
			exit 2
		;;
		-d | --debug) readonly DEBUG=1
			debug "Found '${1}' option"
			shift
		;;
		-n | --namespace) debug "Found '${1}' option"
			debug "Found '${1}' option"
			readonly NAMESPACE="$1"
			debug "NAMESPACE set to '${NAMESPACE}'"
			shift
		;;
		-v | --version) debug "Found '${1}' option"
			print_version
			exit 0
		;;
		-* | --*) err "Unrecognized option '$1'"
			exit 2
		;;
		*) readonly CLASS_NAME="$1";
			debug "CLASS_NAME set to '${1}'"
			readonly FILE_NAME="$CLASS_NAME$CLASS_EXTENSION"
			debug "FILE_NAME set to '${FILE_NAME}'"
			break
		;;
	esac
done
exit
debug "Check that CLASS_NAME not empty"
if [ -z "${CLASS_NAME}" ]; then
	err 'CLASS_NAME parameter required'
	exit 1
fi

debug "Check unit-tests dir: $UNIT_TESTS_DIR"
if [ ! -x "${UNIT_TESTS_DIR}" ]; then
	err 'Unit-tests dir not found'
	exit 1
fi

debug "Check classes dir: ${CLASSES_DIR}"
if [ ! -x "${CLASSES_DIR}" ]; then
	err 'Classes dir not found'
	exit 1
fi

check_dependencies

debug "Open dir ${CLASSES_DIR}"
cd ${CLASSES_DIR}

debug "Find relative path to class"
RELATIVE_CLASS_PATH="$(find . -name "${FILE_NAME}" | sed -e s/\\.\\///)"

debug "Relative path: '${RELATIVE_CLASS_PATH}'"

debug "Check that RELATIVE_CLASS_PATH is not empty"
if [ -z "${RELATIVE_CLASS_PATH}" ]; then
	err "Class '${CLASS_NAME}' not found"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build full class name"
FULL_CLASS_NAME="$(echo "${RELATIVE_CLASS_PATH}" | sed -e s/${CLASS_EXTENSION}// | sed -e s/\\\//\\\\/g)"

debug "Full class name: '${FULL_CLASS_NAME}'"

debug "Check that FULL_CLASS_NAME is not empty"
if [ -z "${FULL_CLASS_NAME}" ]; then
	err "Unable to build full class name"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build relative test path"
RELATIVE_TEST_PATH="$(echo "Tests\\${FULL_CLASS_NAME}" | sed -e s/\\\\/\\\//g)Test$CLASS_EXTENSION"

debug "Relative test path: '${RELATIVE_TEST_PATH}'"

debug "Check that RELATIVE_TEST_PATH is not empty"
if [ -z "${RELATIVE_TEST_PATH}" ]; then
	err "Unable to build relative test path"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build full test name"
FULL_TEST_NAME="$(echo "${RELATIVE_TEST_PATH}" | sed -e s/${CLASS_EXTENSION}// | sed -e s/\\\//\\\\/g)"

debug "Full test name: '${FULL_TEST_NAME}'"

debug "Check that FULL_TEST_NAME is not empty"
if [ -z "${FULL_TEST_NAME}" ]; then
	err "Unable to build full test name"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Open dir ${UNIT_TESTS_DIR}"
cd "${UNIT_TESTS_DIR}"

debug "Build unit test dir"
readonly UNIT_TEST_DIR="$(echo "${RELATIVE_TEST_PATH}" | sed -e s/${CLASS_NAME}Test${CLASS_EXTENSION}//)"

debug "Check that UNIT_TEST_DIR is not empty"
if [ -z "${UNIT_TEST_DIR}" ]; then
	err "Unable to build unit-test dir"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Check unit-test dir: ${UNIT_TEST_DIR}"
if [ ! -x "${UNIT_TEST_DIR}" ]; then
	create_test_dir
fi

debug "Command: phpunit-skelgen --bootstrap="bootstrap-local.php" generate-test "${FULL_CLASS_NAME}" "${RELATIVE_CLASS_PATH}" "${FULL_TEST_NAME}" "${RELATIVE_TEST_PATH}""

phpunit-skelgen --bootstrap="bootstrap-local.php" generate-test "${FULL_CLASS_NAME}" "${RELATIVE_CLASS_PATH}" "${FULL_TEST_NAME}" "${RELATIVE_TEST_PATH}"

debug "Open tests dir ${UNIT_TESTS_DIR}"
cd ${UNIT_TESTS_DIR} >/dev/null 2>&1

debug "Git checkout to master branch"
git checkout master
