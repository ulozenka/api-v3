#!/bin/bash

path_to_script_directory="$(dirname "$0")"
cd "$path_to_script_directory";

../vendor/bin/tester -d extension=json.so .
