<?php 

namespace app\models;

use yii\base\Model;

class Note extends Model
{
    public $id;
    public $name;

    public function rules() :array
    {
        return 
        [
            ['id', 'integer'],
            ['name','required' ]

        ];
    
    }
}
