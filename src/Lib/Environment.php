<?php
declare(strict_types = 1);
namespace App\Lib;

use RuntimeException;

/**
 * Used for detecting the environment.
 *
 * @package default
 */
class Environment
{
    public const DEVELOPMENT = 'development';
    public const DEVELOPMENT_TEST = 'development_test';
    public const STAGING = 'staging';
    public const PRODUCTION = 'production';

    /**
     * Environment variables
     *
     * @var string[]
     */
    protected static $_variables = [];

    /**
     * Returns the current environment
     *
     * @return string
     */
    public static function detect(): string
    {
        $environment = static::read('APP_ENVIRONMENT');
        if (!in_array($environment, [
            self::DEVELOPMENT,
            self::DEVELOPMENT_TEST,
            self::STAGING,
            self::PRODUCTION
        ])) {
            throw new RuntimeException('Invalid Environment: ' . $environment);
        };

        return $environment;
    }

    /**
     * Loads environment variables into static array.
     * Will use .env file in development, env() in production mode.
     *
     * @return void
     * @throws RuntimeException if not all required environment variables were set.
     */
    public static function loadVariables(): void
    {
        $variables = [];
        if (!env('APP_ENVIRONMENT') || env('APP_ENVIRONMENT') == 'development') {
            $loader = new \josegonzalez\Dotenv\Loader(ROOT . '/.env');
            $loader->parse();
            $variables = $loader->toArray();
        } else {
            foreach (static::getRequiredEnvironmentVariables() as $variable) {
                $variables[$variable] = env($variable, false);
            }
        }
        foreach (static::getRequiredEnvironmentVariables() as $variable) {
            if ((!array_key_exists($variable, $variables)) && env('APP_ENVIRONMENT') !== self::DEVELOPMENT_TEST) {
                throw new RuntimeException("Required Environment variable missing: {$variable}");
            }
        }
        static::$_variables = $variables;
    }

    /**
     * Read the value of an environment variable.
     *
     * @param string $variable Variable name
     * @return mixed
     * @throws RuntimeException if the variable isn't set.
     */
    public static function read(string $variable)
    {
        if (!array_key_exists($variable, static::$_variables)) {
            throw new RuntimeException("Environment variable {$variable} is not set.");
        }

        return static::$_variables[$variable];
    }

    /**
     * Returns a list with the required environment variables for running the application.
     *
     * @return string[]
     */
    public static function getRequiredEnvironmentVariables(): array
    {
        return [
            'APP_ENVIRONMENT',
            'EMAIL_TRANSPORT_DEFAULT_URL',
            'DATABASE_URL',
            'MAIN_DOMAIN',
            'FULL_BASE_URL',
            'SESSION_COOKIE_NAME',
            'SENTRY_DSN',
            'SENTRY_DSN_PUBLIC',
            'DEPLOY_PATH'
        ];
    }
}
