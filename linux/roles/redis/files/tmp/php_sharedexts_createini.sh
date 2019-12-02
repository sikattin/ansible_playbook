#!/bin/bash

PHPBIN_PATH=/usr/local/bin/php


if test $# -lt 1; then
    echo "Usage: $0 EXTENSION_DIR"
        exit 1
fi

extension_dir=$1

list=`find ${extension_dir} -name "*.so"`
php_config_path=`${PHPBIN_PATH} --ini | grep -P "^Configuration" | awk -F':' '{print $2}' | sed -e 's/ //g' 2>/dev/null`/php.ini
php_additional_dir=`${PHPBIN_PATH} --ini | grep "Scan for" | awk -F':' '{print $2}' | sed -e 's/ //g' 2>/dev/null`

## check for existing config file
if test ! -e ${php_config_path}; then
    echo "${php_config_path} does not exist" >&2
        exit 2
fi

## check for additional scan directory exists
if test ! -d ${php_additional_dir}; then
    mkdir -p ${php_additional_dir}
    if test $? -eq 0; then
        echo "Create the directory ${php_additional_dir}"
    else
        exit 3
    fi
fi

if test ${php_additional_dir} = "(none)"; then
    for path in ${list[@]}
        do
            filename=`basename ${path}`
                echo "extension=${filename}" >> ${php_config_path}
                echo "Added new line extension=${filename} to ${php_config_path}"
        done
else
    for path in ${list[@]}
    do
        filename=`basename ${path}`
        filename_noext=`echo ${filename} | awk -F'.' '{print $1}'`
        savepath=${php_additional_dir}/${filename_noext}.ini
        touch ${savepath}
        if test $? -eq 0; then
            echo "extension=${filename}" > ${savepath}
            echo "Created ${savepath}"
        fi
    done
fi