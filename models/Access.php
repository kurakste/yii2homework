<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $eventid
 * @property int $userid
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eventid', 'userid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventid' => 'Eventid',
            'userid' => 'Userid',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessQuery(get_called_class());
    }


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userid']);
    }
    
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id'=> 'eventid']);
    }
}
