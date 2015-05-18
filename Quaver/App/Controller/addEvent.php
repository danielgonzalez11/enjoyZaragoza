<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;
use Quaver\App\Model\Category;

class addEvent extends Controller
{   
	public function addEventAction(){//cargar evento
		$category = new Category;
		$categories =$category->getListCategory();

		if(isset($_POST['crear'])){
			$this->saveForm();
		}




		$this->addTwigVars('category', $categories);
		$this->render();
    }


	public function saveForm(){
		if(!empty($_POST['eventName']) && !empty($_POST['category']) && !empty($_POST['image']) 
	    	&& !empty($_POST['date']) && !empty($_POST['description'])  && !empty($_POST['price'])
	    	&& !empty($_POST['capacity']) && !empty($_POST['eventDetails'])){

	    		$name = $_POST['eventName'];
	    		$category = $_POST['category'];
	    		$image = $_POST['image'];
	    		$date = $_POST['date'];
	    		$description = $_POST['description'];
	    		$price = $_POST['price'];
	    		$capacity = $_POST['capacity'];
	    		$details = $_POST['eventDetails'];
	    		//fechas 
	    		$yyyymmdd = substr($date,0,10);
	    		$time =substr($date, -5);
	    		//Control de los radios
	    		if($price == 'cost'){
	    			$price = $_POST['eventPrice'];
	    		}
	    		
	    		if($capacity == 'limited'){
	    			$capacity = $_POST['eventCapacity'];
	    		}
	    		//Imagen del evento
	    		//$type = filetype($image);
	    		//d($type);
	    		
	    	}
	}    
}