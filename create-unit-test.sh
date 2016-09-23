#!/usr/bin/env bash

# Скрипт для создания скелета юнит-теста
#
# TODO: Реализовать добавление док-коммента @group
# TODO: Реализовать добавление алиаса для тестируемого класса

readonly CLASSES_DIR='/home/alex/veles'
readonly UNIT_TESTS_DIR='/home/alex/veles/Tests'
readonly CLASS_EXTENSION='.php'
readonly VERSION='0.0.4'
readonly CURRENT_DIR=$(pwd)

usage_help() {
	print_version
	cat <<EOL
Usage: $0 [OPTION...] <Class name>

Options:
  -v, --version              Show script version
  -h, --help                 Show this help message
  -d, --debug                Run script in debug mode
  -n, --namespace            Set namespace for class

Examples:

./create-unit-test.sh --namespace=View View

./create-unit-test.sh -d -n View View

./create-unit-test.sh --debug ButtonElement

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
error() {
	printf "[$(date --rfc-3339=seconds)]: \033[0;31mERROR:\033[0m $@\n" >&2
}

# Function for warning messages
warning() {
	printf "[$(date --rfc-3339=seconds)]: \033[0;33mWARNING:\033[0m $@\n" >&2
}

check_dependencies() {
	local commands='phpunit-skelgen sed find'
	local result=0

	for i in ${commands}; do
		command -v ${i} >/dev/null 2>&1
		if [ $? -eq 0 ]; then
			debug "Check $i ... OK"
		else
			warning "$i command not available"
			result=1
		fi
	done

	return ${result}
}

create_test_dir() {
	debug "Trying to create test dir"

	mkdir -p "${UNIT_TEST_DIR}"

	if [ $? -ne 0 ]; then
		error "Unable to create unit-test dir"
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
		-n) debug "Found '${1}' option"
			shift
			readonly NAMESPACE="$1"
			debug "NAMESPACE set to '${NAMESPACE}'"
			shift
		;;
		--namespace=?* ) value="${1#*=}"; debug "Found '${1}' option"
			readonly NAMESPACE="$value"
			debug "NAMESPACE set to '${NAMESPACE}'"
			shift
		;;
		-v | --version) debug "Found '${1}' option"
			print_version
			exit 0
		;;
		-* | --*) error "Unrecognized option '$1'"
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

debug "Check that CLASS_NAME not empty"
if [ -z "${CLASS_NAME}" ]; then
	error 'CLASS_NAME parameter required'
	exit 1
fi

debug "Check unit-tests dir: $UNIT_TESTS_DIR"
if [ ! -x "${UNIT_TESTS_DIR}" ]; then
	error 'Unit-tests dir not found'
	exit 1
fi

debug "Check classes dir: ${CLASSES_DIR}"
if [ ! -x "${CLASSES_DIR}" ]; then
	error 'Classes dir not found'
	exit 1
fi

debug "Open dir ${CLASSES_DIR}"
cd ${CLASSES_DIR}

debug "Find relative path to class"
if [ -z "${NAMESPACE}" ]; then
	RELATIVE_CLASS_PATH="$(find . -name "${FILE_NAME}" | sed -e s/\\.\\///)"
else
	RELATIVE_CLASS_PATH="${NAMESPACE}/${FILE_NAME}"
fi

debug "Relative path: '${RELATIVE_CLASS_PATH}'"

debug "Check that RELATIVE_CLASS_PATH is not empty"
if [ -z "${RELATIVE_CLASS_PATH}" ]; then
	error "Class '${CLASS_NAME}' not found"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build full class name"
if [ -z "${NAMESPACE}" ]; then
	FULL_CLASS_NAME="$(echo "Veles\\${RELATIVE_CLASS_PATH}" | sed s/${CLASS_EXTENSION}// | sed 's/\//\\/g')"
else
	FULL_CLASS_NAME="$(echo "${NAMESPACE}\\${CLASS_NAME}")"
fi

debug "Full class name: '${FULL_CLASS_NAME}'"

debug "Check that FULL_CLASS_NAME is not empty"
if [ -z "${FULL_CLASS_NAME}" ]; then
	error "Unable to build full class name"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build relative test path"
RELATIVE_TEST_PATH="$(echo "Tests/${FULL_CLASS_NAME}" | sed 's/\\/\//g' | sed 's/Veles\\//')Test$CLASS_EXTENSION"

debug "Relative test path: '${RELATIVE_TEST_PATH}'"

debug "Check that RELATIVE_TEST_PATH is not empty"
if [ -z "${RELATIVE_TEST_PATH}" ]; then
	error "Unable to build relative test path"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Build full test name"
FULL_TEST_NAME="$(echo "${RELATIVE_TEST_PATH}" | sed -e s/${CLASS_EXTENSION}// | sed -e 's/\//\\/g')"

debug "Full test name: '${FULL_TEST_NAME}'"

debug "Check that FULL_TEST_NAME is not empty"
if [ -z "${FULL_TEST_NAME}" ]; then
	error "Unable to build full test name"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

#debug "Open dir ${UNIT_TESTS_DIR}"
#cd "${UNIT_TESTS_DIR}"

debug "Build unit test dir"
readonly UNIT_TEST_DIR="$(echo "${RELATIVE_TEST_PATH}" | sed -e s/${CLASS_NAME}Test${CLASS_EXTENSION}//)"

debug "Check that UNIT_TEST_DIR is not empty"
if [ -z "${UNIT_TEST_DIR}" ]; then
	error "Unable to build unit-test dir"
	cd ${CURRENT_DIR} >/dev/null 2>&1
	exit 1
fi

debug "Check unit-test dir: ${UNIT_TEST_DIR}"
if [ ! -x "${UNIT_TEST_DIR}" ]; then
	create_test_dir
fi

debug "Open dir ${CLASSES_DIR}"
cd "${CLASSES_DIR}" >/dev/null 2>&1

phpunit-skelgen --bootstrap='Tests/bootstrap.php' generate-test "${FULL_CLASS_NAME}" "${RELATIVE_CLASS_PATH}" "${FULL_TEST_NAME}" "${RELATIVE_TEST_PATH}"

debug "Open tests dir ${UNIT_TESTS_DIR}"
cd ${UNIT_TESTS_DIR} >/dev/null 2>&1

debug "Git checkout to master branch"
git checkout master

debug "Open dir ${CURRENT_DIR}"
cd "${CURRENT_DIR}" >/dev/null 2>&1
