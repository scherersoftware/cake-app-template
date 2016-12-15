#!/bin/bash
sh -c 'if find . -name "*.php" ! -path "./vendor/*" -exec php -l {} 2>&1 \; | grep "syntax error, unexpected"; then exit 1; fi'
sh -c 'if find . -name "*.ctp" ! -path "./vendor/*" -exec php -l {} 2>&1 \; | grep "syntax error, unexpected"; then exit 1; fi'