<?php

namespace core\components\Settings;


class MainSettingsForm extends CommonForm
{
    public $contactEmail;

    public $recipeIntroductoryTextMaxLength;

    public $recipesOnPage;
    public $articlesOnPage;
    public $blogsOnPage;
    public $ingredientsOnPage;
    public $kitchensOnPage;

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

            [['recipesOnPage', 'articlesOnPage', 'blogsOnPage', 'ingredientsOnPage', 'kitchensOnPage'], 'integer'],

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
            'articlesOnPage' => 'Кол-во статей на страницу',
            'blogsOnPage' => 'Кол-во блогов на страницу',
            'ingredientsOnPage' => 'Кол-во ингредиентов на сраницу',
            'kitchensOnPage' => 'Кол-во кухонь мира на сраницу',

            'widgetVK' => 'Код виджета VKontakte',
            'instagramLogin' => 'Ник в инстаграм',
            'widgetFB' => 'Код виджета Facebook',

            'footer' => 'Код подвала',
        ];
    }
}