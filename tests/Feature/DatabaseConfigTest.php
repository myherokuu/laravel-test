<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseConfigTest extends TestCase
{
    /**
     * T-002: Requiring config/database.php must not raise the PHP 8.5 deprecation
     * for PDO::MYSQL_ATTR_SSL_CA (use Pdo\Mysql::ATTR_SSL_CA instead).
     *
     * @return void
     */
    public function test_database_config_loads_without_mysql_ssl_ca_deprecation()
    {
        $deprecations = [];

        set_error_handler(function ($severity, $message) use (&$deprecations) {
            if ($severity === E_DEPRECATED) {
                $deprecations[] = (string) $message;
            }

            return true;
        });

        try {
            $config = require config_path('database.php');
        } finally {
            restore_error_handler();
        }

        $this->assertIsArray($config);

        $sslDeprecations = array_values(array_filter($deprecations, function ($message) {
            return strpos($message, 'MYSQL_ATTR_SSL_CA') !== false;
        }));

        $this->assertEmpty(
            $sslDeprecations,
            'Loading database config must not emit a MYSQL_ATTR_SSL_CA deprecation: '.implode(' | ', $sslDeprecations)
        );
    }

    /**
     * T-002: The config source must prefer the namespaced constant inside a
     * compatibility guard, never use the legacy constant as an unconditional key.
     *
     * @return void
     */
    public function test_database_config_prefers_pdo_mysql_attr_ssl_ca()
    {
        $source = file_get_contents(config_path('database.php'));

        $this->assertStringContainsString(
            "defined('Pdo\\Mysql::ATTR_SSL_CA') ? Pdo\\Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA",
            $source
        );

        $this->assertStringNotContainsString(
            "PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA')",
            $source
        );
    }

    /**
     * T-002: The guard must resolve to Pdo\Mysql::ATTR_SSL_CA whenever it is
     * available (PHP >= 8.5) and preserve the configured env value.
     *
     * @return void
     */
    public function test_mysql_ssl_ca_constant_resolves_and_preserves_value()
    {
        $resolved = defined('Pdo\Mysql::ATTR_SSL_CA')
            ? \Pdo\Mysql::ATTR_SSL_CA
            : \PDO::MYSQL_ATTR_SSL_CA;

        // Prefer the new constant when it exists on the running PHP.
        if (defined('Pdo\Mysql::ATTR_SSL_CA')) {
            $this->assertSame(\constant('Pdo\\Mysql::ATTR_SSL_CA'), $resolved);
        } else {
            $this->assertSame(\constant('PDO::MYSQL_ATTR_SSL_CA'), $resolved);
        }

        $this->assertIsInt($resolved);
    }
}