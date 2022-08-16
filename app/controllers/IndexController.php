<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        echo "Hello World";
    }

    public function startSessionAction()
    {
        $this->session->set('name','Jesse');
    }

    public function getSessionAction()
    {
        echo $this->session->get('name');
    }

}

