<?php

namespace app\models\forms;

use app\models\Event;
use app\models\User;
use app\models\Access;


Class EventForm extends Event
{
    public $users = [];

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] =['users', 'checkUser'];

        return $rules;
    }

    public function beforeSave($insert): bool
    {
        if (!$this->uid) {
            $this->uid = \Yii::$app->getUser()->getId();
        }
        return parent::beforeSave($insert);
    }

    public function checkUser(): void 
    {
        foreach ($this->users as $userId) {
            if (User::find()->andWhere(['id' => $userId])->count('id') == 0) {
                $this->addError(
                    'users', 
                    \sprintf('Пользователя в ID=%d не существует.', $userId)
                );
            }
        
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->users = Access::find()
            ->select(['userid'])
            ->andWhere(['eventid' => $this->id])
            ->column();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Access::deleteAll(['eventid' => $this->id]);
        foreach ($this->users as $userId) {
            Access::SaveAccess($this, $userId);
        }
    }
}
