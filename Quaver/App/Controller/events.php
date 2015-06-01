<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;

class events extends Controller
{   
    //adminorcreator
    //go
	public function eventAction(){//cargar evento

    	$event = new Event;
    	$id = $this->router->getUrlPart(0);

        $this->render();
    }
}