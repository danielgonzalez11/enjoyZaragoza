<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;

class events extends Controller
{   
	public function eventAction(){//cargar evento

    	global $_user;


    	$event = new Event;
    	$id = $this->router->getUrlPart(0);

    	if(is_int($id)){
    		//id del evento

    	}else{
    		//Nombre del evento
    	}

    }
}