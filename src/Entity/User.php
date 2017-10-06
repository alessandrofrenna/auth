<?php

namespace frenna\auth\entities;

use yii\base\Security;
use yii\db\ActiveRecord;
use yii\validators\EmailValidator;
use yii\validators\StringValidator;
use frenna\auth\entities\interfaces\UserIdentityInterface;
use frenna\auth\exceptions\InvalidLoginParametersException;

class User extends ActiveRecords implements UserIdentityInterface
{
    private const STATUS_ACTIVE = 1;
    private const STATUS_DELETED = 0;

    public function tableName()
    {
        return "auth_user";
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

}