<?php

namespace app\objects\ViewModels;

class EventView 
{
    public function canWrite($event): bool
    {
        return $event->uid == \Yii::$app->getUser()->getId();
    }
}
