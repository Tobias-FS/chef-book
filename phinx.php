<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => '',
            'host' => '',
            'name' => '',
            'user' => '',
            'pass' => '',
            'port' => '',
            'charset' => '',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV[ 'DB_HOST' ],
            'name' => $_ENV[ 'DB_NAME' ],
            'user' => $_ENV[ 'DB_USER' ],
            'pass' => $_ENV[ 'DB_PASS' ],
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => '',
            'host' => '',
            'name' => '',
            'user' => '',
            'pass' => '',
            'port' => '',
            'charset' => '',
        ]
    ],
    'version_order' => 'creation'
];
