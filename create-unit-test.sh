#!/usr/bin/env bash

# Скрипт для создания скелета юнит-теста

usage_help() {
	printf "${BOLD}Usage:${CLR}
  create-unit-test.sh [OPTION...] <Class name>

${BOLD}Options:${CLR}
  -v, --version              Show script version
  -h, --help                 Show this help message
  -d, --debug                Run script in debug mode
  -n, --namespace            Set namespace for class

${BOLD}Description:${CLR}
  Script for creating unit-test skeleton

${BOLD}Examples:${CLR}
  ./create-unit-test.sh --namespace='Veles\View' View
  ./create-unit-test.sh -d -n 'Veles\View' View
  ./create-unit-test.sh --debug ButtonElement

"

	return 0
}

print_version() {
	printf "create-unit-test.sh ${BOLD}${VERSION}${CLR} by Yancharuk Alexander\n\n"

	return 0
}

# Function for datetime output
format_date() {
	printf "$GRAY$(date +%Y-%m-%d\ %H:%M:%S)$CLR"
}

# Function for error messages
error() {
	printf "[$(format_date)]: ${RED}ERROR:$CLR $@\n" >&2
}

# Function for informational messages
inform() {
	printf "[$(format_date)]: ${GREEN}INFO:$CLR $@\n"
}

# Function for warning messages
warning() {
	printf "[$(format_date)]: ${YELLOW}WARNING:$CLR $@\n" >&2
}

# Function for debug messages
debug() {
	[ ! -z ${DEBUG} ] && printf "[$(format_date)]: ${GREEN}DEBUG:$CLR $@\n"
}

# Function for operation status
#
# Usage: status MESSAGE STATUS
# Examples:
# status 'Upload scripts' $?
# status 'Run operation' OK
status() {
	if [ -z "$1" ] || [ -z "$2" ]; then
		error "status(): not found required parameters!"
		return 1
	fi

	local result=0

	if [ $2 = 'OK' ]; then
		printf "[$(format_date)]: %-${status_length}b[$GREEN%s$CLR]\n" "$1" "OK"
	elif [ $2 = 'FAIL' ]; then
		printf "[$(format_date)]: %-${status_length}b[$RED%s$CLR]\n" "$1" "FAIL"
		result=1
	elif [ $2 = 0 ]; then
		printf "[$(format_date)]: %-${status_length}b[$GREEN%s$CLR]\n" "$1" "OK"
	elif [ $2 -gt 0 ]; then
		printf "[$(format_date)]: %-${status_length}b[$RED%s$CLR]\n" "$1" "FAIL"
		result=1
	fi

	return ${result}
}

# Function for status on some command in debug mode only
status_dbg() {
	[ -z ${DEBUG} ] && return 0

	if [ -z "$1" ] || [ -z "$2" ]; then
		error "status_dbg(): not found required parameters!"
		return 1
	fi

	local length=$(( ${status_length} - 7 ))
	local result=0

	#debug "status_dbg length: $length"

	if [ $2 = 'OK' ]; then
		printf "[$(format_date)]: ${GREEN}DEBUG:$CLR %-${length}b[$GREEN%s$CLR]\n" "$1" "OK"
	elif [ $2 = 'FAIL' ]; then
		printf "[$(format_date)]: ${GREEN}DEBUG:$CLR %-${length}b[$RED%s$CLR]\n" "$1" "FAIL"
	elif [ $2 = 0 ]; then
		printf "[$(format_date)]: ${GREEN}DEBUG:$CLR %-${length}b[$GREEN%s$CLR]\n" "$1" "OK"
	elif [ $2 -gt 0 ]; then
		printf "[$(format_date)]: ${GREEN}DEBUG:$CLR %-${length}b[$RED%s$CLR]\n" "$1" "FAIL"
		result=1
	fi

	return ${result}
}

# Function for update status formatting length
# Example: update_status_length ${files_array}
update_status_length() {
	for i in ${@}; do
		debug "Element length: ${#i}"
		debug "STATUS_LENGTH before check: ${status_length}"
		if [ ${#i} -gt $(( ${status_length} - 11 )) ]; then
			status_length=$(( ${status_length} + $(( ${#i} - ${status_length} + 12 ))  ))
			debug "NEW STATUS_LENGTH: $status_length"
		fi
	done
}

# Function for checking script dependencies
check_dependencies() {
	local result=0
	local cmd_status

	for i in ${@}; do
		command -v ${i} >/dev/null 2>&1
		cmd_status=$?

		status_dbg "DEPENDENCY: $i" ${cmd_status}

		if [ ${cmd_status} -ne 0 ]; then
			warning "$i command not available"
			result=1
		fi
	done

	debug "check_dependencies() result: $result"

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

get_group() {
	if [ -z "${1}" ]; then
		error 'Function get_group() requires parameter'
		exit 1
	fi

	local group_array=(${1//\// })
	local group="${group_array[0]}"

	echo ${group} | tr '[:upper:]' '[:lower:]'
}

parse_options() {
	local result=0
	local long_optarg=''

	while getopts :vhdn:-: param; do
		[ ${param} = '?' ] && found=${OPTARG} || found=${param}

		debug "Found option '$found'"

		case ${param} in
			v ) print_version; exit 0;;
			h ) usage_help; exit 0;;
			d ) DEBUG=1;;
			n ) NAMESPACE=$OPTARG;;
			- ) case $OPTARG in
					version      ) print_version; exit 0;;
					help         ) usage_help; exit 0;;
					debug        ) DEBUG=1;;
					namespace=?* ) NAMESPACE="${OPTARG#*=}";;
					*            ) warning "Illegal option --$OPTARG"; result=2;;
				esac;;
			* ) warning "Illegal option -$param"; result=2;;
		esac
	done
	shift $((OPTIND-1))

	debug "Variable DEBUG: '$DEBUG'"
	debug "Variable NAMESPACE: '$NAMESPACE'"
	debug "parse_options() result: $result"

	return ${result}
}

function main() {
	readonly local RED="\e[31m"
	readonly local GREEN="\e[32m"
	readonly local YELLOW="\e[33m"
	readonly local GRAY="\e[38;5;242m"
	readonly local BOLD="\e[1m"
	readonly local CLR="\e[0m"

	readonly local CLASSES_DIR='/home/alex/veles'
	readonly local UNIT_TESTS_DIR='/home/alex/veles/Tests'
	readonly local CLASS_EXTENSION='.php'
	readonly local VERSION='1.0.0'
	readonly local CURRENT_DIR=$(pwd)
	readonly local TEST_CASE_NAMESPACE='PHPUnit\Framework\TestCase'

	readonly local CLASS_NAME=${@:$#}
	readonly local FILE_NAME="$CLASS_NAME$CLASS_EXTENSION"

	local DEBUG=
	local status_length=60

	parse_options ${@}

	readonly local parse_result=$?

	[ ${parse_result} = 1 ] && exit 1;
	[ ${parse_result} = 2 ] && usage_help && exit 2;

	debug "Variable CLASS_NAME: '$CLASS_NAME'"
	debug "Variable FILE_NAME: '$FILE_NAME'"

	check_dependencies phpunit-skelgen printf sed find tr perl || exit 1

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
		readonly RELATIVE_CLASS_PATH="$(find . -name "${FILE_NAME}" | sed 's/\.\///')"
	else
		readonly RELATIVE_CLASS_PATH="$(echo "${NAMESPACE}/${FILE_NAME}" | sed 's/Veles\\//' | sed 's/\\/\//g')"
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
		readonly FULL_CLASS_NAME="$(echo "Veles\\${RELATIVE_CLASS_PATH}" | sed s/${CLASS_EXTENSION}// | sed 's/\//\\/g')"
	else
		readonly FULL_CLASS_NAME="$(echo "${NAMESPACE}\\${CLASS_NAME}")"
	fi

	debug "Full class name: '${FULL_CLASS_NAME}'"

	debug "Check that FULL_CLASS_NAME is not empty"
	if [ -z "${FULL_CLASS_NAME}" ]; then
		error "Unable to build full class name"
		cd ${CURRENT_DIR} >/dev/null 2>&1
		exit 1
	fi

	debug "Build relative test path"
	readonly RELATIVE_TEST_PATH="$(echo "Tests/${FULL_CLASS_NAME}" | sed 's/Veles\\//' | sed 's/\\/\//g')Test$CLASS_EXTENSION"

	debug "Relative test path: '${RELATIVE_TEST_PATH}'"

	debug "Check that RELATIVE_TEST_PATH is not empty"
	if [ -z "${RELATIVE_TEST_PATH}" ]; then
		error "Unable to build relative test path"
		cd ${CURRENT_DIR} >/dev/null 2>&1
		exit 1
	fi

	debug "Build full test name"
	readonly FULL_TEST_NAME="$(echo "${RELATIVE_TEST_PATH}" | sed s/${CLASS_EXTENSION}// | sed 's/\//\\/g')"

	debug "Full test name: '${FULL_TEST_NAME}'"

	debug "Check that FULL_TEST_NAME is not empty"
	if [ -z "${FULL_TEST_NAME}" ]; then
		error "Unable to build full test name"
		cd ${CURRENT_DIR} >/dev/null 2>&1
		exit 1
	fi

	debug "Build unit test dir"
	readonly UNIT_TEST_DIR="$(echo "${RELATIVE_TEST_PATH}" | sed s/${CLASS_NAME}Test${CLASS_EXTENSION}//)"

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

	debug "Create group comment tag"
	readonly group=$(get_group ${RELATIVE_CLASS_PATH})
	readonly group_regex=$(printf "%s %q%s" 's=(Generated by PHPUnit_SkeletonGenerator.*)\s=\1\n \* \@group' "${group}" '\n=')
	perl -pi -e "${group_regex}" "${RELATIVE_TEST_PATH}"

	debug "Create class alias"
	readonly alias_regex=$(printf "%s %q%s" 's=(namespace .*;)\s=\1\n\nuse' "${FULL_CLASS_NAME}" ';\n=')
	perl -pi -e "${alias_regex}" "${RELATIVE_TEST_PATH}"

	debug "Change base class"
	perl -pi -e 's/\\PHPUnit_Framework_TestCase/TestCase/' "${RELATIVE_TEST_PATH}"

	debug "Add phpunit TestCase alias"
	readonly test_case_regex=$(printf "%s %q%s" 's=(namespace .*;)\s=\1\n\nuse' "${TEST_CASE_NAMESPACE}" ';=')
	perl -pi -e "${test_case_regex}" "${RELATIVE_TEST_PATH}"

	debug "Open tests dir ${UNIT_TESTS_DIR}"
	cd ${UNIT_TESTS_DIR} >/dev/null 2>&1

	debug "Git checkout to master branch"
	git checkout master

	debug "Open dir ${CURRENT_DIR}"
	cd "${CURRENT_DIR}" >/dev/null 2>&1
}

main ${@}

exit 0
