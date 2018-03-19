<?php

namespace core\components\Settings;


class EmailSettingsForm extends CommonForm
{
    public $emailConfirmBody;
    public $passwordResetBody;

    public function rules()
    {
        return [
            [['emailConfirmBody', 'passwordResetBody'], 'required'],
            [['emailConfirmBody', 'passwordResetBody'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'emailConfirmBody' => 'Подтверждение регистрации',
            'passwordResetBody' => 'Восстановление пароля',
        ];
    }
}