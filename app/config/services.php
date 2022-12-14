<?php
declare(strict_types=1);

use Phalcon\Escaper;
use Phalcon\Flash\Direct as Flash;
// use Phalcon\Flash\Session as FlashSession;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Url as UrlResolver;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});


    // Router
// $di->set('router',function(){
// $router = new \Phalcon\Mvc\Router();
// // $router->add();
// return $router;
// });

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'path' => $config->application->cacheDir,
                'separator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */

// $di->set('flash',function(){
//     $flash = new \Phalcon\Flash\Session([
//         'error'=>'alert alert-danger',
//         'success'=>'alert alert-success',
//         'notice' => 'alert alert-info',
//         'warning'=> 'alert alert-warning'
//     ]);
//     return $flash;
// });


// $di->set('flash', function () {
//     $escaper = new Escaper();
//     $flash = new Flash($escaper);
//     $flash->setImplicitFlush(false);
//     $flash->setCssClasses([
//         'error'   => 'alert alert-danger',
//         'success' => 'alert alert-success',
//         'notice'  => 'alert alert-info',
//         'warning' => 'alert alert-warning'
//     ]);

//     return $flash;
// });

$di->set('flash', function () {
    $escaper = new Escaper();
    $flash = new Flash($escaper);
    $flash->setImplicitFlush(false);
    $flash->setCssClasses([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);

    return $flash;
});


// $di->setShared('session', function(){
//     $session = new \Phalcon\Session\Adapter\Files();
//     $session->start();
//     return $session;
// });

// $di->set('flash', function () {
//     return new Flash(array(
//         'error'   => 'alert alert-danger',
//         'success' => 'alert alert-success',
//         'notice'  => 'alert alert-info',
//         'warning' => 'alert alert-warning'
//     ));
// });
/**
 * Start the session the first time some component request the session service
 */

// $di->set('dispatcher',function() use($di){
//     $eventsManager = $di->getShared('eventsManager');
//     //Custom ACL Class
//     $permission = new Permission();
//     //Listen the events from the permission class
//     $eventsManager->attach('dispatch',$permission);

//     $dispatcher = new \Phalcon\Mvc\Dispatcher();
//     $dispatcher->setEventsManager($eventsManager);
    
//     return $dispatcher;
// });

$di->set('flashSession', function(){
    $escaper = new Escaper();
    $flashSession = new Phalcon\Flash\Session($escaper);
    
    $flashSession->setCssClasses([
        'error'   => 'alert alert-danger msg',
        'success' => 'alert alert-success msg',
        'notice'  => 'alert alert-info msg',
        'warning' => 'alert alert-warning msg'
    ]);

    return $flashSession;
});

$di->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => sys_get_temp_dir(),
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});
