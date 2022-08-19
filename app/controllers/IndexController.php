<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function signoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('signin');
    }

    public function startSessionAction()
    {
        $this->session->set('user',[
            'name'=>'sandesh',
            'age'=>'20',
            'character'=>'no character'
        ]);
        $this->session->set('name','Jesse');
    }



    public function getSessionAction()
    {
        $user = $this->session->get('user');
        print_r($user);
        echo $this->session->get('name');
    }

    public function removeSessionAction()
    {
        $this->session->remove('name');
    }

    public function destroySessionAction()
    {
        $this->session->destroy();
    }
}

