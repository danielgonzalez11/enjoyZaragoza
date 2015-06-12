<?php


require 'index.php';

use Quaver\App\Model\Event;

$eventsToFinish = Event::getProjectsToFinish();
if ($eventsToFinish) {
    foreach ($eventsToFinish as $v) {
        $v->status = 'completed';
        $v->save();
    }
}

/*
Código del cron en ubuntu
crontab -e editar el fichero, poner
*/
//    */5 * * * * /usr/bin/php /var/www/enjoyZaragoza/Cron/finishedEvents.php >/dev/null 2>&1
