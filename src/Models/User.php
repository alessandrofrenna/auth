<?php

namespace frenna\auth\models;

use yii\base\Security;
use yii\db\ActiveRecord;
use yii\validators\EmailValidator;
use yii\validators\StringValidator;
use yii\web\IdentityInterface;
use frenna\auth\exceptions\InvalidLoginParametersException;

class User extends ActiveRecords implements IdentityInterface
{
    private const STATUS_ACTIVE = 1;
    private const STATUS_DELETED = 0;

    public function tableName()
    {
        return "auth_user";
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        throw new \yii\base\NotSupportedException("This functionality is not supported yet!");
    }

    public static function findUser($param)
    {
        if((new EmailValidator)->validate($param)) {
            return findByEmail($param);
        } else if ((new StringValidator)->validate($param)){
            return findByUsername($param);
        }

        throw new InvalidLoginParametersException('Set a valid email/username');
    }

    private function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    private function findByEmail($email)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    private function validatePassword($input)
    {
        return (new Security)->validatePassword($input, $this->password);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authkey)
    {
        return $this->getAuthKey() === $authkey; 
    }

}