<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

	public function initialize()
	{

        if($this->session->has('id')){
        	$user_details = $this->session->get('role');
        	$role = $user_details;
        	if(!$role)
        		
        			echo 'Unauthorized Access';
        			exit;
        
	}else{
		echo 'exit';exit;
	}
}
    function getUrlSegment($intNumber){
		$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
		return (isset($segments[$intNumber]))?$segments[$intNumber]:"";
	}
}
