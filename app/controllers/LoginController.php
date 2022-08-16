<?php

class LoginController extends \Phalcon\Mvc\Controller 
{
    public function initialize()
    {
        $this->view->setTemplateAfter('default');
    }

    public function indexAction()
    {
        echo "Login";
    }

    public function processAction( $username=false, $age=12)
    {

    }
}