<?php

require 'index.php';

use Quaver\Core\Router;
use Quaver\App\Model\Event;
use Quaver\App\Model\EventInfo;
use Quaver\App\Model\EventFile;

$router = new Router();
if (!isset($_REQUEST['id'], $_REQUEST['name'])) {
    header("Location :/");
    exit;
}


$id = $_REQUEST['id'];
$name = $_REQUEST['name'];
if($name != 'image'){
    $value = $_REQUEST['value'];    
}
$correct = false;


switch ($name) {
    case 'eventName':
        $event = new Event();
        $event->getFromId($id);
        $event->name = $value;
        $event->save();
        $correct = true;
        echo $correct;    
        break;
    case 'date':
        $event = new Event();
        $event->getFromId($id);
        $dateFinish = date('Y-m-d H:i:s', strtotime($value));
        if($dateFinish !== '1970-01-01 01:00:00'){
            $event->dateFinish = $dateFinish;
            $event->save();
            $correct = true;
            echo $correct;    
        }
        break;
    case 'category':
        $event = new Event();
        $event->getFromId($id);
        $event->category = $value;
        $event->save();
        $correct = true;
        echo $correct;        
        break;
    case 'description':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->description = $value;
        $eventInfo->save();
        $correct = true;
        echo $correct;
        break;
    case 'eventPhone':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->phone = $value;
        $eventInfo->save();
        $correct = true;
        echo $correct;    
        break;
    case 'capacity':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->capacity = $value;
        $eventInfo->save();
        $correct = true;
        echo $correct;    
        break;
    case 'price':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->price = $value;
        $eventInfo->save();
        $correct = true;
        echo $correct;    
        break;
    case 'eventDetails':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->details = $value;
        $eventInfo->save();
        $correct = true;
        echo $correct;    
        break;
    case 'image':
        if (empty($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
            $router->dispatch('e404');
            exit;
        }
        $error = false;
        $imgPath = FILES_PATH . '/events/' . $id; 
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
                        if(move_uploaded_file($_FILES['image']['tmp_name'], $imgPath)){
                            $eventFile = new EventFile();
                            $eventFile->getFromEvent($id);
                            $eventFile->source = $imgPath;
                            $eventFile->file = $_FILES['image']['type'];
                            if($eventFile->save()){
                                echo $imgPath;
                            }
                        }

                  }else{
                    echo $error;
                  }


        break;

    default:
        echo $correct;
}

