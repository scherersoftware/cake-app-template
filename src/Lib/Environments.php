<?php
namespace App\Lib;

use Exception;

/**
 * Used for detecting the environment.
 *
 * @package default
 */
class Environments
{
    const DEVELOPMENT = 'development';
    const DEVELOPMENT_TEST = 'development_test';
    const STAGING = 'staging';
    const PRODUCTION = 'production';

    /**
     * Returns the current environment
     *
     * @return string
     */
    public static function detect()
    {
        if (PHP_SAPI == 'cli') {
            $environment = Environments::_detectCli();
        } else {
            $environment = Environments::_detectHttp();
        }
        return $environment;
    }

    /**
     * Detects the environment when called via Console
     *
     * @return string
     */
    protected static function _detectCli()
    {
        $environment = self::DEVELOPMENT;
        $currentWorkingDirectory = getcwd();
        if (env('ENVIRONMENT') == 'staging') {
            $environment = self::STAGING;
        }
        if (env('ENVIRONMENT') == 'production') {
            $environment = self::PRODUCTION;
        }
        return $environment;
    }

    /**
     * Detects the environment when called via HTTP
     *
     * @return string
     * @throws \Exception If no host url matches given ones
     */
    protected static function _detectHttp()
    {
        if (env('ENVIRONMENT')) {
            return env('ENVIRONMENT');
        }
        $host = env('HTTP_HOST');
        $environment = self::DEVELOPMENT;

        if (strpos($host, 'cakephp-app-template-test.com') !== false) {
            $environment = self::DEVELOPMENT;
        } elseif (strpos($host, 'cakephp-app-template.com') !== false) {
            $environment = self::PRODUCTION;
        }
        return $environment;
    }
}
