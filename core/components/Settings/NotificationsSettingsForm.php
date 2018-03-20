<?php

namespace core\components\Settings;


class NotificationsSettingsForm extends CommonForm
{
    public $emptyBlockForCookbook;
    public $emptyBlockForPosts;
    public $emptyBlockForPhotos;
    public $emptyBlockForRecipes;
    public $signupOkMessage;
    public $signupConfirmMessage;
    public $photoReportAddedMessage;
    public $photoReportText;

    public function rules()
    {
        return [
            [['emptyBlockForCookbook', 'emptyBlockForPosts', 'emptyBlockForPhotos', 'emptyBlockForRecipes', 'signupOkMessage', 'signupConfirmMessage'], 'string'],
            [['photoReportAddedMessage', 'photoReportText'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'emptyBlockForCookbook' => 'Сообщение если кулинарная книга пуста',
            'emptyBlockForPosts' => 'Сообщение если постов у пользователя нет',
            'emptyBlockForPhotos' => 'Сообщение если фотоотчётов у пользователя нет',
            'emptyBlockForRecipes' => 'Сообщение если рецептов у пользователя нет',
            'signupOkMessage' => 'Сообщение об успешной регистрации',
            'signupConfirmMessage' => 'Сообщение после подтверждения адреса e-mail',
            'photoReportAddedMessage' => 'Сообщение об успешном добавлении фотоотчёта',
            'photoReportText' => 'Текст при добавлении фотоотчёта',
        ];
    }
}