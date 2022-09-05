<?php

$router = $di->getRouter();

// Define your routes here

$router->handle($_SERVER['REQUEST_URI']);

// $router->add('/blog/create',['controller'=> 'blog','action'=>'create']);
// $router->add('/blog/create/submit',['controller'=>'blog','action'=>'createSubmit']);

$router->add('/superhero/jump',[
    'controller'=>'test',
    'action'=>'jump'
]);

$router->add('/blog',[
    'controller'=>'blog',
    'action'=>'index'
]);
$router->add('/show',[
    'controller'=>'blog',
    'action'=>'show'
]);
$router->add('/blogedit/:params',[
    'controller' => 'blog',
    'action' => 'edit',
    'params' => 1
]);
$router->add('/blogedit/submit',[
    'controller' => 'blog',
    'action' => 'editSubmit'
]);
$router->add('/blog/editsubmit',[
    'controller' => 'blog',
    'action' => 'editsubmit'
]);

$router->add('/blogdelete/:params',[
    'controller' => 'blog',
    'action' => 'delete',
    'params' => 1
]);

$router->add('/prodedit/:params',[
    'controller' => 'product',
    'action' => 'edit',
    'params' => 1
]);

$router->add('/proddelete/:params',[
    'controller' => 'product',
    'action' => 'delete',
    'params' => 1
]);

$router->add('/details/:params',[
    'controller' => 'front',
    'action' => 'detail',
    'params' => 1
]);