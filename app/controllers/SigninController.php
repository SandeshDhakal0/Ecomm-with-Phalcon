<?php

class SigninController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function doSigninAction()
    {
        $this->view->disable();
        $user = User::findFirst([
            "email = :email: AND password = :password:",
            "bind" => [
                "email" => $this->request->getPost('email'),
                "password" => $this->request->getPost('password')
            ]
        ]);
        if ($user) {
            $this->session->set('id',$user->id);
            $this->session->set('role',$user->role);
            $this->response->redirect("dashboard/index");
        }
        $this->flashSession->error('Incorrect Credentials');
        return $this->response->redirect("signin");
    }
    // public function doSigninAction()
    // {
    //     if($this->request->isAjax() == true){
    //         $user = new Users();
    //         $email = $this->request->getPost('email');
    //         $password = $this->request->getPost('password');

    //         if( username != "" && password != ""  ){
    //             $user->email = $email;
    //             $user->password = $password;
    //             return $this->response
    //         }
    // }
}

