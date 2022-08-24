<?php
use \Phalcon\Tag;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use App\Models;

class FrontController extends ControllerBase
{
   
    public function indexAction()
    {
        // $this->view->pick('../front/layout/header'); 
        
        // $this->view->pick('../front/layout/footer');     
    }


    public function womensdressAction()
    {
        
    }

    public function blogAction()
    {
        $data = Blog::find();
        $this->view->blog = $data; 
    }
    
}