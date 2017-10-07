<?php

namespace frenna\auth\models;

use yii\base\Model;
use frenna\auth\entities\User;

class LoginForm extends Model 
{
    public $credential;
    public $password;

    private $user;

    public function rules()
    {
        return [
            ['credential', 'string', 'required'],
            ['password', 'required'],
            ['password', 'checkAndValidatePW'],
        ];
    }

    public function checkAndValidatePW($attribute, $params)
    {
        if(!$this->hasErrors()){
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password)) {
                $this->addError('Incorrect login credentials, please insert the correct username/email and password.');
            }
        }
    }

    public function getUser()
    {
        if(!$this->user){
            return User::findUser($this->credential);
        }
        return $this->user;
    }

    public function login()
    {
        return Yii::$app->user->login($this->getUser());
    }

}
