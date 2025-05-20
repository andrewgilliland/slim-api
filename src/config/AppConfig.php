<?php
namespace App\Config;

use Dotenv\Dotenv;

class AppConfig
{
    private static bool $loaded = false;

     private static function loadEnv(): void
    {
        if (!self::$loaded) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2)); // Adjust path as needed
            $dotenv->load();
            self::$loaded = true;
        }
    }


    public static function get(string $key, $default = null)
    {
        self::loadEnv();
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }

    public static function db(): array
    {
        return [
            'host' => self::get('DB_HOST', 'localhost'),
            'user' => self::get('DB_USER', 'root'),
            'pass' => self::get('DB_PASS', ''),
            'name' => self::get('DB_NAME', 'api_db'),
        ];
    }

    public static function jwtSecret(): string
    {
        return self::get('JWT_SECRET', 'changeme');
    }
}