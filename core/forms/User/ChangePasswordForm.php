<?php

namespace core\forms\User;


use core\entities\User\User;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $confirmPassword;

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['oldPassword', 'required', 'message' => 'Введите старый пароль'],
            ['oldPassword', 'string'],
            ['oldPassword', 'validatePassword'],

            ['newPassword', 'required', 'message' => 'Придумайте новый пароль'],
            ['confirmPassword', 'required', 'message' => 'Повторите новый пароль'],
            [['newPassword'], 'string', 'min' => 5],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'],
        ];
    }

    public function validatePassword($attribute, $params, $validator)
    {
        if (!$this->_user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Пароль неверный!');
        }
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'confirmPassword' => 'Подтверждение пароля',
        ];
    }
}