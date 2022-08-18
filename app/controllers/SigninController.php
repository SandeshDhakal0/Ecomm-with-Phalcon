<?php

use Phalcon\Acl\Adapter\Memory;

class SigninController extends ControllerBase
{

    public function indexAction()
    {
        
    }

    public function doSigninAction()
    {
// ACL for login 
        $acl = new Memory();
        $acl->addRole('admin');
        $acl->addRole('user');
        // $acl->addRole('guest');
        $acl->addComponent(
            'adminPrivelage',
            [
                'dashboard'
            ]
        );
        $acl->addComponent(
            'userPrivelage',
            [
                'front'
            ]
        );
        $acl->allow('admin', 'adminPrivelage', 'dashboard');
        $acl->allow('user','userPrivelage','front');
// Signin starts from here
        $this->view->disable();
        $user = User::findFirst("email='" . $this->request->getPost('email') . "'");
        if ($user) {
            if ($user->password == $this->request->getPost('password')) {
                if ($acl->isAllowed('admin', 'adminPrivelage', 'dashboard')) {
                    $this->session->set('auth', ['id' => $user->id, 'role' => $user->role]);
                    $this->response->redirect("dashboard");
                } else {
                    echo "no user found";
                } 
                if ($acl->isAllowed('user','userPrivelage','front')) {
                    $this->session->set('auth', ['id' => $user->id, 'role' => $user->role]);
                    $this->response->redirect("front");
                } else {
                echo "Cannot be logged in.";
            } 
            }
        }
    }}

// $this->response->redirect('/profile');
// $this->view->disable();