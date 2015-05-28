<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;
use Quaver\App\Model\Category;
use Quaver\App\Model\EventInfo;
use Quaver\App\Model\EventFile;

class addEvent extends Controller
{   
	public function addEventAction(){//cargar evento
		global $_user;
		if (!$_user->logged){
			header("Location: /login");
		    exit;
		}
		$category = new Category;
		$categories =$category->getListCategory();

		if(isset($_POST['crear'])){
			$this->saveForm($_user);
			$this->addTwigVars('display', true);
		}




		$this->addTwigVars('category', $categories);
		$this->render();
    }


	public function saveForm($_user){
		$user = $_user;

		if(!empty($_POST['eventName']) && !empty($_POST['category']) && !empty($_FILES['image']) 
	    	&& !empty($_POST['date']) && !empty($_POST['description'])  && !empty($_POST['price'])
	    	&& !empty($_POST['capacity']) && !empty($_POST['eventDetails']) && !empty($_POST['eventPhone'])){

	    		$name = $_POST['eventName'];
	    		$category = $_POST['category'];
	    		$date = $_POST['date'];
	    		$description = $_POST['description'];
	    		$price = $_POST['price'];
	    		$capacity = $_POST['capacity'];
	    		$details = $_POST['eventDetails'];
	    		$phone = $_POST['eventPhone'];
	    		//Horas 
	    		$time =substr($date, -8);
	    		//Control de los radios
	    		if($price == 'cost'){
	    			$price = $_POST['eventPrice'];
	    		}
	    		
	    		if($capacity == 'limited'){
	    			$capacity = $_POST['eventCapacity'];
	    		}
	    		//Imagen del evento
			    $CurrencyDate = date('Y/m/d H:i:s');
			    $dateFinish = date('Y-m-d H:i:s', strtotime($date));

			    //Events
			    $events = new Event();
			    $events->id_creator_user = $user->id;
			    $events->name = $name;
			    $events->dateCreate = $CurrencyDate;
			    $events->dateFinish = $dateFinish;
			    $events->time = $time;
			    $events->status = 'accepted';
			    $events->category = $category;
			    $events->save();

			    //Events info
			    $eventsInfo = new EventInfo();
			    $eventsInfo->id_event = $events->id;
			    $eventsInfo->description = $description;
			    $eventsInfo->phone = $phone;
			    $eventsInfo->price = $price;
			    $eventsInfo->capacity = $capacity;
			    $eventsInfo->details = $details;
			    $eventsInfo->save();

			    //Events file

	    		$error = false;
	    		
	    		$imgPath = FILES_PATH . '/events/' . $events->id; 
			      switch ($_FILES['image']['type']) {
			        case('image/jpeg'):
			        case('image/jpg'):
			          $imgPath .= '.jpg';
			          break;
			        case('image/png'):
			          $imgPath .= '.png';
			          break;
			        case('image/gif'):
			          $imgPath .= '.gif';
			          break;
			        default:
			          $error = true;
			          break;
			      }
			      if(!$error){
			      	move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);	
			      }

			    $eventsFiles = new EventFile();
			    $eventsFiles->event = $events->id;
			    $eventsFiles->source = $imgPath;
			    $eventsFiles->file = $_FILES['image']['type'];
			    $eventsFiles->save();

			    //Error
			    $this->addTwigVars('error', $error);			            
	    	}
	}    
}