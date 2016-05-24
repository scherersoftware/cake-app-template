# CakePHP 3 cakephp-app-template

[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

Pre-Configured Application Template for CakePHP 3

## i18n Extract Command

    bin/cake i18n extract --paths=src/,plugins/,config/ --merge=no --extract-core=no --output src/Locale/ --overwrite

## Custom Bootstrap (Frontend)

A custom Bootstrap LESS file includes some overrides to variables. It is located in `webroot/less/custom_bootstrap.less` and includes the `custom_variables.less` file from the same folder.

Command for compiling the file is:

    lessc webroot/less/custom_bootstrap.less > webroot/css/bootstrap.custom.css

## Custom Bootstrap & SB Admin Theme

For the Admin Plugin we have a custom Bootstrap LESS file (same system as for the Frontend) and the `SB Admin 2` LESS sources. Use the following commands to build the Bootstrap and SbAdmin CSS files:

    lessc plugins/Admin/webroot/less/custom_bootstrap.less > plugins/Admin/webroot/css/bootstrap.custom.css
    lessc plugins/Admin/webroot/less/sb-admin-2/sb-admin-2.less > plugins/Admin/webroot/css/sb-admin-2.custom.css

## Admin Backend

The password to enter the admin backend under /admin/login is "asdfyxcv"

## Environment Variables

Copy `.env.default` and rename it to `.env`. Be sure that FULL_BASE_URL and MAIN_DOMAIN are set to your local domain.

## To Be Documented

- DBSchema.mwb
- schema shell & data seeding
- custom font awesome
- list used third-party libraries
- cake monitor
