<?php

use Phalcon\Acl\Adapter\Memory;

class SigninController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function doSigninAction()
    { // ACL for login 
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
        $acl->allow('user', 'userPrivelage', 'front'); // Signin starts from here
        $this->view->disable();
        $user = User::findFirst([
            "email = :email: AND password = :password:",
            "bind" => [
                "email" => $this->request->getPost('email'),
                "password" => $this->request->getPost('password')
            ]
        ]);
        if ($user) {
            if ($user->password == $this->request->getPost('password')) {
                $this->session->set('id', $user->id);
                $this->session->set('role', $user->role);
                if ($user->role == 'admin') {
                    $this->response->redirect("dashboard");
                }
                else {

                    $this->response->redirect("front");
                }
            }
        }
        else {
            $this->flashSession->error("User Not Found");
            $this->response->redirect("signin");
        }
    }
}



// $this->response->redirect('/profile');
// $this->view->disable();