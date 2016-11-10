#!/bin/bash
vendor/bin/phpunit

# these are paths to our own code
paths[0]="src"
paths[1]="tests"
paths[2]="plugins"

for path in "${paths[@]}"
do
    echo $path
    vendor/bin/phpcs -n -p --extensions=php --standard=vendor/cakephp/cakephp-codesniffer/CakePHP "${path}"
done
