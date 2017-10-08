<?php

namespace frenna\auth\models;

use Yii;
use yii\base\Model;
use frenna\auth\models\User;

class LoginForm extends Model 
{
    public $credential;
    public $password;

    private $user;

    public function rules()
    {
        return [
            ['credential', 'string'],
            [['credential', 'password'], 'required'],
            ['password', 'checkAndValidatePW'],
        ];
    }

    public function checkAndValidatePW($attribute, $params)
    {
        if(!$this->hasErrors()){
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect login credentials');
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
        if($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }        
    }

}
