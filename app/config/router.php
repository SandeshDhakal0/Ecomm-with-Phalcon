<?php

$router = $di->getRouter();

// Define your routes here

$router->handle($_SERVER['REQUEST_URI']);

// $router->add('/blog/create',['controller'=> 'blog','action'=>'create']);
// $router->add('/blog/create/submit',['controller'=>'blog','action'=>'createSubmit']);
