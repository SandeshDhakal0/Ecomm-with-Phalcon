<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();
$acl->addRole('admin');
$acl->addRole('user');
$acl->addRole('guest');
$acl->addComponent(
    'adminPrivelage',
    [
        'dashboard'
    ]
);
$acl->allow('admin','adminPrivelage','dashboard');



