<?php

class DashboardController extends ControllerBase
{
   public function initialize(){
    if(!$this->session->has('id')){
         $this->response->redirect('signin');
    }

   }
    public function indexAction()
    {
        
    }

    
    
}