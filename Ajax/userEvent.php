<?php
require 'index.php';

use Quaver\Core\Router;
use Quaver\App\Model\UserEvent;

$router = new Router();

if (!isset($_REQUEST['status'], $_REQUEST['id'], $_REQUEST['user'])) {
    $router->dispatch('e404');
    exit;
}

$status = $_REQUEST['status'];
$event = (int) $_REQUEST['id'];
$user =	(int) $_REQUEST['user'];

$ue = new userEvent();
$ue->getFromUser($_user->id, $projectId);
$correcto = true;

if ($status != $opt->follow) {
    $opt->follow = $status;
    $correcto = $opt->save();
}

$resultado = array(
    'success' => $correcto,
    'status' => $status,
);

echo json_encode($resultado);
