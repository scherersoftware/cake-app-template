#!/bin/bash
php-cs-fixer fix --fixers=ordered_use,phpdoc_indent -vv src/ tests/
vendor/bin/phpcbf -v --standard=vendor/cakephp/cakephp-codesniffer/CakePHP --extensions=php src/ tests/