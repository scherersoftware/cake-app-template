<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/*
 * You can remove this if you are confident that your PHP version is sufficient.
 */
if (version_compare(PHP_VERSION, '7.1.0') < 0) {
    trigger_error('Your PHP version must be equal or higher than 7.1.0 to use this template.', E_USER_ERROR);
}

/*
 *  You can remove this if you are confident you have intl installed.
 */
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use this template.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use this template.', E_USER_ERROR);
}

/*
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use App\Lib\Environment;
use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/* Set up the environemt*/

Environment::loadVariables();
define('ENVIRONMENT', Environment::detect());

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

if (isset($_GET['cache']) && $_GET['cache'] == 'disable') {
    Cache::disable();
}
if (ENVIRONMENT === Environment::DEVELOPMENT || ENVIRONMENT === Environment::DEVELOPMENT_TEST) {
    Configure::write('debug', true);
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('Europe/Berlin');

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
Plugin::load('Monitor', ['bootstrap' => true, 'routes' => true]);

$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new \Monitor\Error\ConsoleErrorHandler(Configure::consume('Error')))->register();
} else {
    (new \Monitor\Error\ErrorHandler(Configure::consume('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
    Plugin::load('CakeDC/Mixer', ['bootstrap' => true, 'routes' => true]);
}

Plugin::load('BootstrapUI');
Plugin::load('CkTools', ['bootstrap' => false, 'routes' => true]);
Plugin::load('FrontendBridge', ['bootstrap' => false, 'routes' => true, 'autoload' => true]);
Plugin::load('AuthActions', ['bootstrap' => false, 'routes' => false]);
Plugin::load('ListFilter', ['bootstrap' => false, 'routes' => false]);
Plugin::load('Notifications', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Attachments', ['bootstrap' => false, 'routes' => true]);
Plugin::load('AssetCompress', ['bootstrap' => true]);
Plugin::load('Josegonzalez/CakeQueuesadilla');
Plugin::load('ADmad/Glide');
Plugin::load('Schema', ['bootstrap' => true]);
Plugin::load('CakeApiBaselayer', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Api/V1', ['bootstrap' => false, 'routes' => true]);
Plugin::load('LanguageSwitcher');

/**
 * Datasource Type Mappings
 */
Type::map('json', 'CkTools\Database\Type\JsonType');

/**
 * Load Additional Configs
 */
//Configure::load('CkTools.countries');

Configure::write('AssetCompress.rawMode', false);
if (ENVIRONMENT === Environment::DEVELOPMENT) {
    Configure::write('AssetCompress.rawMode', true);
}

/**
 * Enable default locale format parsing.
 * This is needed for matching the auto-localized string output of Time() class when parsing dates.
 */
Type::build('datetime')->useLocaleParser();

/**
 * Debug Logging Helper
 *
 * @return void
 */
function dlog()
{
    $args = func_get_args();
    foreach ($args as $arg) {
        if (!is_string($arg)) {
            $arg = print_r($arg, true);
        }
        \Cake\Log\Log::write('debug', print_r($arg, true));
    }
}
