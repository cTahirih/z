<?php
/**
 * Autoconfigure Phinx with the application's credentials.
 * 
 * @author Jaime G. Wong <j@jgwong.org>
 */

$configFile = __DIR__ . '/config/autoload/database.php';
if (!file_exists($configFile)) {
    echo PHP_EOL;
    echo 'FATAL ERROR: No config/autoload/database.php file found.' . PHP_EOL;
    echo 'Have you configured your database yet?' . PHP_EOL;
    echo PHP_EOL;
    exit;
}

$db = include $configFile;

return [
    'paths' => [
        'migrations' => __DIR__ . '/migrations',
        'seeds'      => __DIR__ . '/migrations/seeds',
    ],
    
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'default',
        'default' => [
            'adapter' => $db['type'],
            'host'    => $db['host'],
            'name'    => $db['database'],
            'user'    => $db['username'],
            'pass'    => $db['password'],
            'port'    => $db['port'],
            'charset' => 'utf8',
        ],
        'test' => [
            'adapter' => $db['type'],
            'host'    => $db['host'],
            'name'    => $db['database'] . '_test',
            'user'    => $db['username'],
            'pass'    => $db['password'],
            'port'    => $db['port'],
            'charset' => 'utf8',
        ],
    ],
];
