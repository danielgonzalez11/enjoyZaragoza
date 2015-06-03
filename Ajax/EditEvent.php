<?php

require 'index.php';

use Quaver\Core\Router;
use Quaver\App\Model\Event;
use Quaver\App\Model\EventInfo;
use Quaver\App\Model\EventFile;

$router = new Router();

if (!isset($_REQUEST['id'], $_REQUEST['name'], $_REQUEST['value'])) {
    $router->dispatch('e404');
    exit;
}

$id = $_REQUEST['id'];
$name = $_REQUEST['name'];
$value = $_REQUEST['value'];
$correct = false;


switch ($name) {
    case 'eventName':
        $event = new Event();
        $event->getFromId($id);
        $event->name = $value;
        $event->save();
        $correct = true;
        break;
    case 'date':
        $event = new Event();
        $event->getFromId($id);
        $dateFinish = date('Y-m-d H:i:s', strtotime($value));
        $event->dateFinish = $dateFinish;
        $event->save();
        $correct = true;
        break;
    case 'category':
        $event = new Event();
        $event->getFromId($id);
        $event->category = $value;
        $event->save();
        $correct = true;    
        break;
    case 'description':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->description = $value;
        $eventInfo->save();
        $correct = true;
        break;
    case 'eventPhone':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->phone = $value;
        $eventInfo->save();
        $correct = true;    
        break;
    case 'capacity':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->capacity = $value;
        $eventInfo->save();
        $correct = true;    
        break;
    case 'price':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->price = $value;
        $eventInfo->save();
        $correct = true;    
        break;
    case 'eventDetails':
        $eventInfo = new EventInfo();
        $eventInfo->getFromEvent($id);
        $eventInfo->details = $value;
        $eventInfo->save();
        $correct = true;    
        break;
    case 'image':
        $correct = true;
        break;
    
}

echo $correct;
