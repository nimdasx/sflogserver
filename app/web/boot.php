<?php
try {

    putenv("SERVICE_NGINX_CLIENT_MAX_BODY_SIZE=100m");
    $_SERVER['SERVICE_NGINX_CLIENT_MAX_BODY_SIZE'] = '100m';

    if (!file_exists(__DIR__ . '/../env.php')) {
        echo "file konfigurasi belum ada";
        die;
    }
    $env = include __DIR__ . '/../env.php';
    $x = include '../' . $env->konfig_aktif . '.php';

    if ($x->display_errors == true) {
        ini_set('display_errors', 1);
    } else {
        ini_set('display_errors', 0);
    }

    date_default_timezone_set('Asia/Jakarta');

    if (PHP_OS == 'WINNT') {
        setlocale(LC_TIME, 'ID');
    } else {
        setlocale(LC_TIME, 'id_ID.utf8');
    }

    define('APP_TYPE', 'WEB');

    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../static.php';

    $loader = new Phalcon\Loader;
    $loader->registerDirs(array(
        '../lib/',
        '../model/',
        '../web/controller/',
        '../web/listener/',
    ))->register();

    $di = new Phalcon\Di\FactoryDefault;
    $di->setShared('config', $x);

    $router = new Phalcon\Mvc\Router();
    $di->set('router', $router);

    $view = new Phalcon\Mvc\View;
    $di->set('view', $view);

    $dbparam = [
        'host' => $x->db->host,
        'username' => $x->db->username,
        'password' => $x->db->password,
        'dbname' => $x->db->dbname,
        'charset' => $x->db->charset,
        'port' => $x->db->port,
    ];
    $pdo = new Phalcon\Db\Adapter\Pdo\Mysql($dbparam);
    $di->setShared('db', $pdo);

    $di->set('dispatcher', function () {
        $eventsManager = new Phalcon\Events\Manager;
        $eventsManager->attach('dispatch:beforeExecuteRoute', new ListenerKeamanan());
        $eventsManager->attach('dispatch:beforeException', new ListenerKerusakan());
        $dispatcher = new Phalcon\Mvc\Dispatcher;
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    });

    $application = new Phalcon\Mvc\Application($di);
    $uri = $_GET['_url'] ?? '';
    $application->handle($uri)->send();

} catch (\Exception $e) {

    $respon = At::setJsonRespon($e->getMessage(), 400);
    $respon->send();

}