#!/bin/bash
bin/cake i18n extract --paths=src/,plugins/,config/ --merge=no --extract-core=no --output src/Locale/ --overwrite --no-location
bin/cake CkTools.I18n updateFromCatalog --overwrite --strip-references
bin/cake CkTools clearCache