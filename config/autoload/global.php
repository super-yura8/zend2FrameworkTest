<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => '127.0.0.1',
                    'port'     => '8889',
                    'user'     => 'root',
                    'password' => 'new-password',
                    'dbname'   => 'test',
                    'charset'  => 'utf8',
                ]
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'name' => 'Application Migrations',
                'directory' => __DIR__ . '/../../migrations',
                'namespace' => 'Applications\Migrations',
                'table_name' => 'doctrine_migrations'
            ]
        ]
    ],
);
