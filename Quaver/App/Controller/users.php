<?php

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\App\Model\User;

class users extends Controller
{   


    public function userAction(){//cargar ventana de usuarios

    	global $_user;


    	$user = new User;
        $usuarios = $user->getList();
        var_dump($usuarios);
        exit;

    	$id = $this->router->getUrlPart(0);
    	$usuario = $user->getFromId($id);
    	if($usuario->id){
    		if($_user->logged){
    			//Puede dar reputación, ve el perfil,
    			//La vista cambia dependiendo de si somos o no su usuario.
    			
    			if($_user->id == $usuario->id){
    				//Estamos conectados en nuestro perfil, podemos editarlo
    				//
    			}


    		}else{
    		  //Tiene que conectarse para dar reputación


    		}

    	}else{
    		echo "usuario no existe";
    		//LLevarle a la pagina de errores!
    	}
    	$this->render();
    }


}


