# CakePHP 3 App Template

[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

Pre-Configured Application Template for CakePHP 3

## Installation

- Run `composer install`
- Create a database for the project
- Copy `.env.default` and rename it to `.env`, then change your configuration accordingly. Be sure that FULL_BASE_URL and MAIN_DOMAIN are set to your local domain.
- Create the database structure using `bin/cake migrations migrate`
- Seed the database with demo data using `bin/cake migrations seed`

You can now open the public home page, or log in to /admin using the following credentials:

email: john.doe@example.com

password: asdfyxcv


## i18n Extract Command

Use this commmand to parse the project for translation strings and update the `default.pot` file.

    bin/cake i18n extract --paths=src/,plugins/,config/ --merge=no --extract-core=no --output src/Locale/ --overwrite

## Custom Bootstrap (Frontend)

A custom Bootstrap LESS file includes some overrides to variables. It is located in `webroot/less/custom_bootstrap.less` and includes the `custom_variables.less` file from the same folder.

Command for compiling the file is:

    lessc webroot/less/custom_bootstrap.less > webroot/css/bootstrap.custom.css

## Custom Bootstrap & SB Admin Theme

For the Admin Plugin we have a custom Bootstrap LESS file (same system as for the Frontend) and the `SB Admin 2` LESS sources. Use the following commands to build the Bootstrap and SbAdmin CSS files:

    lessc plugins/Admin/webroot/less/custom_bootstrap.less > plugins/Admin/webroot/css/bootstrap.custom.css
    lessc plugins/Admin/webroot/less/sb-admin-2/sb-admin-2.less > plugins/Admin/webroot/css/sb-admin-2.custom.css


## Strict Passwords with StrictPasswordBehavior
Activate the strict password requirements by setting the StrictPasswordBehavior in UsersTable; default Configuration is set in this example

    $this->addBehavior('CkTools.StrictPassword', [
        // minimal password length
        'minPasswordLength' => 10,
        // fistname and surname are not allowed in password (case insensitive)
        'noUserName' => true,
        // at least one special char is needed in password
        'specialChars' => true,
        // at least one char in upper case is needed in password
        'upperCase' => true,
        // at least one char in lower case is needed in password
        'lowerCase' => true,
        // at least one numeric value is needed in password
        'numericValue' => true,
        // reuse of old passwords is not allowed: number of old passwords to preserve
        'oldPasswordCount' => 4
    ]);
