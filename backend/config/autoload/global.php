<?php
/**
 * Global Configuration Override
 *
 * IMPORTANT: This file is part of the repository. Do not include passwords,
 * keys, credentials or any other sensitive information.
 */

use Base\Env;

// Load database configuration
$db = include __DIR__ . '/database.php';

if (Env::get() == 'testing') {
    // Add suffix to use the test database when in testing environment
    $db['database'] .= '_test';
}

return [
    'session_config' => [
        'name'            => 'dolce-gusto-dashboard',
        'cookie_httponly' => true,
        'use_cookies'     => true,
        'cookie_secure'   => false,
    ],
    
    /**
     * Start of database-related configurations.
     *
     * If your application doesn't use a database, please remove these
     * configurations (and database.php.* files) to avoid confusion.
     */
    'db' => [
        'dsn'            => sprintf('%s:dbname=%s;host=%s', $db['type'], $db['database'], $db['host']),
        'username'       => $db['username'],
        'password'       => $db['password'],
        'port'           => $db['port'],
        'driver'         => 'Pdo',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND =>
                "SET NAMES 'UTF8', sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));"
        ],
    ],
    
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'PdoResource' => 'Base\Db\PdoResourceFactory',
        ],
    ],
    
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'pdo'         => 'PdoResource',
                
                'doctrine_type_mappings' => [
                    'enum' => 'string'
                ],
            ],
        ],
    ],
    /** End of database-related configurations. */
    
    'tactician' => [
        'middleware' => [
            'App\Tactician\Middleware\ReportCacheMiddleware' => 10,
        ],
    ],
];
