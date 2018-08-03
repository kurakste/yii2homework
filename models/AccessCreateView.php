<?php 

namespace app\models;


use app\models\Note;
use yii\helpers\BaseArrayHelper;

class AccessCreateView
{
    public function getEventOptions()
    {
        $models = Event::find()->all();

        return BaseArrayHelper::map($models, 'id', 'name');
    }

    public function getUserOptions()
    {
        $models = User::find()->all();
        
        return BaseArrayHelper::map($models, 'id', 'username');

    }

}
