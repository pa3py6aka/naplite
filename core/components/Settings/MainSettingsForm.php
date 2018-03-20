<?php

namespace core\components\Settings;


class MainSettingsForm extends CommonForm
{
    public $contactEmail;

    public $recipeIntroductoryTextMaxLength;

    public $recipesOnPage;

    public $widgetVK;
    public $instagramLogin;
    public $widgetFB;

    public $footer;

    public function rules()
    {
        return [
            ['contactEmail', 'required'],
            ['contactEmail', 'email'],
            ['recipeIntroductoryTextMaxLength', 'integer'],

            [['recipesOnPage'], 'integer'],

            [['widgetVK', 'instagramLogin', 'widgetFB'], 'string'],
            ['footer', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'contactEmail' => 'E-mail на который будут приходить сообщения с формы обратной связи',
            'recipeIntroductoryTextMaxLength' => 'Максимальный размер вводного текста в рецепте',

            'recipesOnPage' => 'Кол-во рецептов на страницу',

            'widgetVK' => 'Код виджета VKontakte',
            'instagramLogin' => 'Ник в инстаграм',
            'widgetFB' => 'Код виджета Facebook',

            'footer' => 'Код подвала',
        ];
    }
}