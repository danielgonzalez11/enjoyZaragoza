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
        
        $event = new Event();
        $eventos = $event->getList();
        $eventsCarousel = array();

        //Calculando eventos para el carousel
        //$CurrencyDate = date('Y-m-d');
        //$NextWeek = strtotime ( '+7 day' , strtotime ( $CurrencyDate ) ) ;
        //$NextWeek = date ( 'Y-m-d' , $NextWeek );
        
        $CurrencyDate = date('Y-m-d H:i:s');
        $NextWeek = strtotime ( '+7 day' , strtotime ( $CurrencyDate ) ) ;
        $NextWeek = date('Y-m-d H:i:s', $NextWeek);

        $datetimeNow = new \DateTime($CurrencyDate);
        $datetimeFinished = new \DateTime($NextWeek);
        d($datetimeNow);
        d($datetimeFinished);
        $interval = $datetimeFinished->diff($datetimeNow);
        dd($interval);
        for ($i=0; $i < count($eventos); $i++) 
            $datetimeEvent = new \DateTime($eventos[$i]->dateFinish);
            $fecha = date('Y-m-d',$fecha);
            $c=0;
           if( $fecha >= $CurrencyDate && $fecha <= $NextWeek){
            //Eventos de la semana, almacenarlos para mostrarlos en el carousel.
            $eventsCarousel[$c]=$eventos[$i];
            $c++;
        }*/
        
        
        $this->addTwigVars('sliderItems', $eventsCarousel);
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


