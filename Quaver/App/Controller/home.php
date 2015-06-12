<?php
/*
 * Copyright (c) 2014 Alberto González
 * Distributed under MIT License
 * (see README for details)
 */

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\Core\Lang;
use Quaver\App\Model\Event;
use Quaver\App\Model\UserEvent;

/**
 * Home controller (language, maintenance and index)
 * @package App
 */
class home extends Controller
{   
    /**
     * Show homepage
     * @return type
     */
    public function homeAction()
    {   
        global $_user;
        $event = new Event();
        $eventos = $event->getList();   
        $events = array();
        

        if($eventos){
            for ($i=0; $i < count($eventos); $i++) {
                if($_user->logged){
                    if($eventos[$i]->status == "completed"){
                        if(empty($events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))])){
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] = '<a class="completed" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';
                        }else{
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] .= '<a class="completed" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';
                        }
                    }else{
                        $userEvent = new UserEvent();
                        $userEvent->getFollow($eventos[$i]->id,$_user->id);
                        if(is_null($userEvent->id)){
                            //No va a este evento
                            if(empty($events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))])){
                                $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] = '<a href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                            }else{
                                $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] .= '<a href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                            }
                        }else{
                            //Va a este evento
                            if(empty($events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))])){
                                $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] = '<a class="userGo" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                            }else{
                                $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] .= '<a class="userGo" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';
                            }

                        }
                    }
                }else{
                    if($eventos[$i]->status == "completed"){
                        if(empty($events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))])){
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] = '<a class="completed" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                        }else{
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] .= '<a class="completed" href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                        }
                        
                    }else{
                        if(empty($events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))])){
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] = '<a href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                        }else{
                            $events[(date('m-d-Y', strtotime($eventos[$i]->dateFinish)))] .= '<a href=/event/'.$eventos[$i]->id.'>'.$eventos[$i]->name.'</a>';                        
                        }
                        
                    }  
                }
            }
        }
        $this->addTwigVars('eventos',json_encode($events));
        $this->addTwigVars('siteTitle', "Welcome to Enjoyzaragoza" . ' - ' . BRAND_NAME);
        $this->render();
    }

    /**
     * Show maintenance page
     * @return type
     */
    public function maintenanceAction()
    {
        if (defined('MAINTENANCE_MODE') && MAINTENANCE_MODE) {
            $this->render();
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }

    /**
     * Change language
     * @return type
     */
    public function languageAction()
    {
        $language = new Lang;
        $language->getFromSlug($this->router->getUrlPart(0));

        if ($language) {
            $language->setCookie();
            if (!empty($_SERVER['HTTP_REFERER'])){
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            } else{
                header("Location: /");
                exit;
            }
        } else {
            $this->router->dispatch('e404');
            exit;
        }
    }

  
}


