<?php

namespace core\components\Settings;


use Yii;
use yii\base\Model;

class SettingsForm extends Model
{
    public $recipeIntroductoryTextMaxLength;
    public $photoReportText;

    public $widgetVK;
    public $instagramLogin;
    public $widgetFB;

    public function init()
    {
        $settings = Yii::$app->settings->getAll();
        foreach ($settings as $param => $value) {
            $this->$param = $value;
        }
        parent::init();
    }

    public function extraFields()
    {

    }

    public function rules()
    {
        return [
            ['recipeIntroductoryTextMaxLength', 'integer'],
            ['photoReportText', 'string'],
            [['widgetVK', 'instagramLogin', 'widgetFB'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'recipeIntroductoryTextMaxLength' => 'Максимальный размер вводного текста в рецепте',
            'photoReportText' => 'Текст при добавлении фотоотчёта',
            'widgetVK' => 'Код виджета VKontakte',
            'instagramLogin' => 'Ник в инстаграм',
            'widgetFB' => 'Код виджета Facebook',
        ];
    }
}