<?php

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/console');
define('APP_TYPE', 'CONSOLE');

if (!file_exists(BASE_PATH . '/env.php')) {
    echo "file konfigurasi belum ada";
    die;
}

if (!file_exists(BASE_PATH . '/vendor')) {
    echo "folder vendor belum ada, baca README.md ya\n";
    die;
}

use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Loader;

date_default_timezone_set("Asia/Jakarta");

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/static.php';

$env = include BASE_PATH . '/env.php';
$config = include BASE_PATH . '/' . $env->konfig_aktif . '.php';

$di = new CliDi();

$di->setShared('config', $config);

$di->setShared('db', function () {
    $config = $this->getConfig();
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->db->adapter;
    $params = [
        'host' => $config->db->host,
        'username' => $config->db->username,
        'password' => $config->db->password,
        'dbname' => $config->db->dbname,
        'charset' => $config->db->charset,
        'port' => $config->db->port,
    ];
    if ($config->db->adapter == 'Postgresql') {
        unset($params['charset']);
    }
    $connection = new $class($params);
    return $connection;
});

$loader = new Loader();
$loader->registerDirs([
    APP_PATH . '/task',
    BASE_PATH . '/model',
    BASE_PATH . '/lib',
]);
$loader->register();

$console = new ConsoleApp($di);

$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {

    $console->handle($arguments);

    $config = $di->getConfig();
    if (isset($config["printNewLine"]) && $config["printNewLine"]) {
        echo PHP_EOL;
    }

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(255);
}
