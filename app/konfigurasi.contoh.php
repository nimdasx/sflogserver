<?php
return new Phalcon\Config([
    'db' => [
        'adapter' => 'Mysql',
        'host' => '',
        'username' => '',
        'password' => '',
        'dbname' => '',
        'charset' => 'utf8',
        'port' => '3306',
    ],
    'printNewLine' => true,
    'display_errors' => true,
    'debug' => true,
    'apx_ids' => [
        'atgov-api-gundul-pacul',
        'atogv-api-ringut'
    ]
]);
