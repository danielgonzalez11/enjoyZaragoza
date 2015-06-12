<?php
require 'index.php';

use Quaver\Core\Router;
use Quaver\App\Model\UserEvent;

$router = new Router();

if (!isset($_REQUEST['id'], $_REQUEST['user'])) {
    $router->dispatch('e404');
    exit;
}

$event = $_REQUEST['id'];
$user =	$_REQUEST['user'];
$follow = false;

$ue = new UserEvent();
$ue->getFollow($event,$user);

if(is_null($ue->id)){
	$ue->id_user = $user;
	$ue->id_event = $event;
	$ue->save();
	$follow = true;	
}else{
	$ue->delete();
}

echo json_encode($follow);
