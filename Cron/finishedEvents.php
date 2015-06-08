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
