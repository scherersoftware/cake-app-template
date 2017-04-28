#!/bin/bash

# trace ERR through pipes
set -o pipefail

# trace ERR through 'time command' and other functions
set -o errtrace

# set -u : exit the script if you try to use an uninitialised variable
set -o nounset

# set -e : exit the script if any statement returns a non-true return value
set -o errexit

error=false

while IFS= read -r -d '' file
do
    EXTENSION="${file##*.}"

    if [ "$EXTENSION" == "php" ] || [ "$EXTENSION" == "ctp" ]
    then
        RESULTS=`php -l $file`

        if [ "$RESULTS" != "No syntax errors detected in $file" ]
        then
            echo $RESULTS
            error=true
        fi
    fi
done <   <(find . -print0)

if [ "$error" = true ] ; then
    exit 1
else
    exit 0
fi
