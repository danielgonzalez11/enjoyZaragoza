<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;
use Quaver\App\Model\EventInfo;
use Quaver\App\Model\EventFile;
use Quaver\App\Model\User;
use Quaver\App\Model\UserEvent;
use Quaver\App\Model\Category;

class events extends Controller
{   
    //adminorcreator
    //go
    //category

	public function eventAction(){//cargar evento
		global $_user;

    	$event = new Event();
    	$eventInfo = new EventInfo();
    	$eventFile = new EventFile();
		$userEvent = new User();
		$category = new Category;
        $uEvent = new UserEvent();
		$categories =$category->getListCategory();		
        $go="";
		$adminorcreator = false;
    	$id = $this->router->getUrlPart(0);
    	$event->getFromId($id);

    	if(!is_null($event->id)){
    		$userEvent->getFromId($event->id_creator_user);
    		$eventInfo->getFromEvent($event->id);
    		$eventFile->getFromEvent($event->id);
    		$path = realpath($eventFile->source);
    		$path = substr($path, 22);

    		if($_user->logged){
	    		if($_user->level == 'admin' || $userEvent->id == $_user->id){
	    			$adminorcreator = true;
	    		}    			
    		}

            if($_user->logged){
                $uEvent->getFollow($event->id,$_user->id);
                if(is_null($uEvent->id)){
                    $go = false;
                }else{
                    $go = true;
                }
            }
                        

    		$this->addTwigVars('category', $categories);
    		$this->addTwigVars('userEvent', $userEvent);
    		$this->addTwigVars('eventInfo', $eventInfo);
    		$this->addTwigVars('path', $path);
    		$this->addTwigVars('event', $event);
            $this->addTwigVars('go', $go);
    		$this->addTwigVars('adminOrCreator', $adminorcreator);
    	}else{
    		header('Location: /');
    		exit;
    	}

    	$this->render();  
    }
}