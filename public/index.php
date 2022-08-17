<?php

declare(strict_types=1);

use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    $di['modelsMetadata'] = function () {
        $metaData = new \Phalcon\Mvc\Model\MetaData\Memory(
            [
                "prefix"   => "my-prefix",
                "lifetime" => 86400,
            ]
        );
        return $metaData;
    };


    // Router
    // $di->set('router',function(){
    //     $router = new \Phalcon\Mvc\Router();
    //     // $router->add();
    //     return $router;
    // });

    $di->set('dispatcher',function() use($di){
        $eventsManager = $di->getShared('eventsManager');
        //Custom ACL Class
        $permission = new Permission();
        //Listen the events from the permission class
        $eventsManager->attach('dispatch',$permission);

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        
        return $dispatcher;
    });

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
    } catch (\Exception $e) {
        echo $e->getMessage() . '<br>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
