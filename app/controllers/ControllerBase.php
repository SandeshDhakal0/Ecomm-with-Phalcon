<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    function getUrlSegment($intNumber){
		$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
		return (isset($segments[$intNumber]))?$segments[$intNumber]:"";
	}
}
