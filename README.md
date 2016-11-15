![CakePHP 3 Notifications Plugin](https://raw.githubusercontent.com/scherersoftware/cakephp-app-template/master/app-template.png)

[![Build Status](https://travis-ci.org/scherersoftware/cakephp-app-template.svg?branch=master)](https://travis-ci.org/scherersoftware/cakephp-app-template)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

Pre-Configured Application Template for CakePHP 3

## Installation

This is just a brief installation guide. A much more detailed version will be available soon:

Use composer to install the package:

`$ composer create-project --stability dev scherersoftware/cakephp-app-template <project-name>`

First, we have to install sass and some npm packages

```
$ gem install sass
$ npm install
```

Install the bower dependencies:

`$ bower install`

After that, run `$ bin/ext_compile.sh` to recompile the assets.

Stuff like mySQL user and password is configured by using PHP Dotenv.
Just rename the `.env.deault` to `.env` and set the values.
Be sure to also set `SESSION_COOKIE_NAME`
and `MAIN_DOMAIN`, as these values are mandatory for a correct session setup.

Next, setup your database. We're using cakephp/migrations for that:

**Attention**: If you're using a MySQL Version before 5.7, the `ModelHistory.Migration` will fail, due to not supported datatypes. As a workaround, please use the `schema.sql`, located at `vendor\codekanzlei\cake-model-history\config` instead.

`$ bin/cake migrations migrate`

Also run the migrations from Josegonzalez/CakeQueuesadilla, as we use this plugin to send out the restore password emails.

`$ bin/cake migrations migrate -p Josegonzalez/CakeQueuesadilla`

Now seed the database with a default user

`$ bin/cake migrations seed`

Please also run the provided SQL-Query on the top of the demo page to enable the login.

Default email: `john.doe@example.com`, default password: `password`

## Credits

This template is based on the [CakePHP Application Skeleton](https://github.com/cakephp/app)

Also, we're using the following awesome open-source projects:
- [CakePHP Framework](https://github.com/cakephp/cakephp)
- [Asset Compress by Mark Story](https://github.com/markstory/asset_compress)
- [Bootstrap UI by FriendsOfCake](https://github.com/FriendsOfCake/bootstrap-ui)
- [CakePHP Glide by ADmad](https://github.com/admad/cakephp-glide)
- [PHP Dotenv by Jose Diaz-Gonzalez](https://github.com/josegonzalez)
- [JShrink by Robert Hafner](https://github.com/tedivm/jshrink)
- [Assert by Benjamin Eberlei](https://github.com/beberlei/assert)


