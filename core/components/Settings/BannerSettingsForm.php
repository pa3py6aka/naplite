<?php

namespace core\components\Settings;


class BannerSettingsForm extends CommonForm
{
    public $bannerSimple1;
    public $bannerSimple2;
    public $bannerCenterTop;
    public $bannerPagenator;
    public $bannerBeforeSteps;
    public $bannerDirectUnderMenu;
    public $bannerDirectAfterCategories;
    public $bannerFooter;

    public $bannerSimple1_show;
    public $bannerSimple2_show;
    public $bannerCenterTop_show;
    public $bannerPagenator_show;
    public $bannerBeforeSteps_show;
    public $bannerDirectUnderMenu_show;
    public $bannerDirectAfterCategories_show;
    public $bannerFooter_show;

    public function rules()
    {
        return [
            [['bannerSimple1', 'bannerSimple2', 'bannerCenterTop', 'bannerPagenator', 'bannerBeforeSteps'], 'string'],
            [['bannerDirectUnderMenu', 'bannerDirectAfterCategories', 'bannerFooter'], 'string'],
            [['bannerSimple1_show', 'bannerSimple2_show', 'bannerCenterTop_show', 'bannerPagenator_show', 'bannerBeforeSteps_show'], 'boolean', 'falseValue' => 0, 'trueValue' => 1],
            [['bannerDirectUnderMenu_show', 'bannerDirectAfterCategories_show', 'bannerFooter_show'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bannerSimple1' => 'Код баннера 1 справа',
            'bannerSimple2' => 'Код баннера 2 справа',
            'bannerCenterTop' => 'Горизонтальный баннер в самом верху сайта 90х100%',
            'bannerPagenator' => 'Нижний баннер между выводом контента и пагинатором на всех разделах сайта',
            'bannerBeforeSteps' => 'Горизонтальный баннер между ингредиентами и шагами рецепта',
            'bannerDirectUnderMenu' => 'Блок директ-рекламы под основным меню на всех страницах',
            'bannerDirectAfterCategories' => 'Блок директ-рекламы между рубрикатором и выводом на всех разделах сайта',
            'bannerFooter' => 'Блок в футере сайта',

            'bannerSimple1_show' => 'Показывать',
            'bannerSimple2_show' => 'Показывать',
            'bannerCenterTop_show' => 'Показывать',
            'bannerPagenator_show' => 'Показывать',
            'bannerBeforeSteps_show' => 'Показывать',
            'bannerDirectUnderMenu_show' => 'Показывать',
            'bannerDirectAfterCategories_show' => 'Показывать',
            'bannerFooter_show' => 'Показывать',
        ];
    }
}