<?php

namespace core\forms\auth;


use core\entities\User\User;
use yii\base\Model;

class SignupForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Укажите e-mail'],
            ['password', 'required', 'message' => 'Придумайте пароль'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email'],
            ['password', 'string', 'min' => 5],
        ];
    }
}