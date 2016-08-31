<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    public function rules() {

        return [

            ['login', 'required'], 
            ['password', 'required', 'on'=>'production'],

            ['login', 'validateLogin', 'on'=>'local'],
            ['password', 'validatePassword', 'on'=>'production'],
            [['login', 'password'], 'safe'],
        ];
    }

    public function validateLogin($attribute, $params) {   

        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user) {
                User::newUser($this->$attribute);
            }
        }
    }

    public function validatePassword($attribute, $params) {

        if (!$this->hasErrors()) {

            $user = $this->getUser();
            if (!User::checkPassword($user, $this->login, $this->password)) {
                $this->addError('password', 'Пароль или логин не правильный');
            }

        }
    }

    public function attributeLabels(){
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function login() {
        
        if (Common::isLocalServer())
            $this->scenario = 'local';
        else
            $this->scenario = 'production';


        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600*24*300);
        } else {
            return false;
        }
    }

    public function getUser(){

        return User::findByUsername($this->login);
    }
}
