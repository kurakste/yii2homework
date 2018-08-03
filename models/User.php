<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $passwordhash
 * @property string $accesstoken
 *
 * @property Event[] $events
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'passwordhash', 'accesstoken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usernamename' => 'Name',
            'passwordhash' => 'Passwordhash',
            'accesstoken' => 'Access Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['uid' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->getIsNewRecord() && $this->passwordhash) {
            $this->passwordhash = $this->saltPassword($this->passwordhash);
        }

        if (!$this->accesstoken) {
            $this->accesstoken = \Yii::$app->security->generateRandomString();
        }

        return true;
    }

    public function saltPassword(string $password)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

	/**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
		return self::findOne(['id' => $id]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
		return self::findOne(['accesstoken' => $token]);
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($name)
    {
		return self::findOne(['username' => $name]);
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
		return $this->accesstoken;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
		return $this->accesstoken === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* var_dump(md5($password)); die; */
        return Yii::$app->getSecurity()
            ->validatePassword($password, $this->passwordhash);
    }
	/**
	 * @return ActiveQuery
	 */
	public function getNotes(): ActiveQuery
	{
		return $this->hasMany(Event::class, ['uid' => 'id']);
    }
}
