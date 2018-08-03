<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name  Имя
 * @property string $start_at Время начало.
 * @property string $end_at Время окончания.
 * @property string $created_at Время создания.
 * @property string $updater_at Время последнего изменения.
 * @property int $uid  Идентификатор пользователя
 *
 * @property Users $u
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_at', 'end_at', 'created_at', 'updater_at'], 'safe'],
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => ' Имя',
            'start_at' => 'Время начало.',
            'end_at' => 'Время окончания.',
            'created_at' => 'Время создания.',
            'updater_at' => 'Время последнего изменения.',
            'uid' => ' Идентификатор пользователя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * {@inheritdoc}
     * @return EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }
}
