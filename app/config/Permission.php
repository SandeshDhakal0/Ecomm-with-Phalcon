<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Add the roles
 */
$acl->addRole('admin');
$acl->addRole('user');
$acl->addRole('guest');


/**
 * Add the Components
 */

$acl->addComponent(
    'main',
    [
        'dashboard',
        'users',
        'view',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

$acl->addComponent(
    'session',
    [
        'login',
        'logout',
    ]
);

/**
 * Now tie them all together 
 */
$acl->allow('admin', 'main', 'users');
$acl->allow('admin', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');
// $acl->deny('guest', '*', 'view');

// true - defined explicitly
$acl->isAllowed('admin', 'main', 'dashboard');

// true - defined with wildcard
$acl->isAllowed('admin', 'session', 'login');

// true - defined with wildcard
// $acl->isAllowed('user', 'reports', 'view');

// false - defined explicitly
// $acl->isAllowed('guest', 'reports', 'view');

// false - default access level
// $acl->isAllowed('guest', 'reports', 'add');

