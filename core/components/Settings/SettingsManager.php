<?php

namespace core\components\Settings;


use yii\base\Model;
use yii\helpers\Json;

class SettingsManager
{
    private $settings;
    public $file = __DIR__ . '/settings.json';
    public $emails = __DIR__ . '/emails.html';

    /* @note Don't change keys in this array!!! */
    private $default = [
        'contactEmail' => 'contact@na-plite.ru',
        'recipeIntroductoryTextMaxLength' => 500,
        'recipesOnPage' => 30,

        'widgetVK' => "VK.Widgets.Group('vk_groups', {
                mode: 3,
                width: 'auto',
                no_cover: 1,
                color1: '#ffffff'
            }, 20003922);",
        'instagramLogin' => 'prikol_tyt',
        'widgetFB' => '<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=true&appId=115551535801362" width="100%" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>',

        'bannerSimple1' => '<img src="/img/banner-naplite.jpg" width="240" height="400" alt="">',
        'bannerSimple2' => '<img src="/img/banner-naplite.jpg" width="240" height="400" alt="">',
        'bannerCenterTop' => '',
        'bannerPagenator' => '',
        'bannerBeforeSteps' => '',
        'bannerDirectUnderMenu' => '',
        'bannerDirectAfterCategories' => self::DIRECT_AFTER_CATEGORIES,
        'bannerFooter' => '',

        'bannerSimple1_show' => 1,
        'bannerSimple2_show' => 1,
        'bannerCenterTop_show' => 1,
        'bannerPagenator_show' => 1,
        'bannerBeforeSteps_show' => 1,
        'bannerDirectUnderMenu_show' => 1,
        'bannerDirectAfterCategories_show' => 1,
        'bannerFooter_show' => 1,

        'footer' => self::FOOTER,

        'emptyBlockForCookbook' => 'Вы ещё не добавили ни одного рецепта в избранное',
        'emptyBlockForPosts' => 'Вы не написали ни одного поста в форум',
        'emptyBlockForPhotos' => 'Вы не добавили ни одного фотоотчёта',
        'emptyBlockForRecipes' => 'Вы не добавили ни одного рецепта',
        'emailConfirmBody' => "<p>Здравствуйте, для завершения регистрации перейдите по следующей ссылке:</p>\n\r<p><a href='{LINK}'>{LINK}</a></p>",
        'passwordResetBody' => "<p>Перейдите по этой ссылке для восстановления пароля:</p>\n\r<p><a href='{LINK}'>{LINK}</a></p>",
        'signupOkMessage' => "<h1>Поздравляем!</h1>\n\rВы успешно зарегистрировались, мы отправили <br />\n\rвам письмо на почту, для подтверждения <br />\n\rвашей регистрации.",
        'signupConfirmMessage' => "<h1>Успешно!</h1>\n\rВаш адрес e-mail успешно подтверждён!",
        'photoReportAddedMessage' => "Фотография успешно добавлена<br />\n\rв фотоотчёт по рецепту",
        'photoReportText' => 'Добавьте свой фотоотчёт о приготовленном блюде по данному рецепту',
    ];

    public function __construct()
    {
        $this->settings = Json::decode(file_get_contents($this->file));
        $this->prepare();
        //print_r($this->settings);exit;
    }

    public function get($param)
    {
        if (isset($this->settings[$param])) {
            return $this->settings[$param];
        }
        return $this->default[$param];
    }

    public function getAll(): array
    {
        return $this->settings;
    }

    /**
     * @param Model $form
     * @return bool|int
     */
    public function saveForm(Model $form)
    {
        foreach ($form->attributes as $param => $value) {
            $this->settings[$param] = $value;
        }
        return file_put_contents($this->file, Json::encode($this->settings));
    }

    private function prepare()
    {
        foreach ($this->default as $param => $value) {
            if (!isset($this->settings[$param]) || $this->settings[$param] == '') {
                $this->settings[$param] = $value;
            }
        }
    }

    private const FOOTER = <<<HTML
<div class="footer_col">
                <b><a href="#">Закуски</a></b>
                <a href="#">Бутерброды</a>
                <a href="#">Горячие</a>
                <a href="#">Мясные</a>
                <a href="#">Из субпродуктов</a>
                <a href="#">Из рыбы</a>
                <a href="#">Из морепродуктов</a>
                <a href="#">Из овощей</a>
                <a href="#">Из фруктов</a>
                <a href="#">С грибами</a>
                <a href="#">Паштеты и террины</a>
                <a href="#">Закусочные торты</a>
                <a href="#">Закуски в лаваше</a>
                <a href="#">Из сыра и творога</a>
                <a href="#">Профитроли, тарталетки</a>
                <a href="#">Холодец и заливное</a>
                <a href="#">Закуски из яиц</a>
                <p></p>
                <b><a href="#">Напитки</a></b>
                <a href="#">Алкогольные</a>
                <a href="#">Безалкогольные</a>
                <a href="#">Горячие</a>
                <a href="#">Фруктовые</a>
                <a href="#">Овощные</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Салаты</a></b>
                <a href="#">Классические салаты</a>
                <a href="#">Тёплые салаты</a>
                <a href="#">Мясные салаты</a>
                <a href="#">Из птицы</a>
                <a href="#">С субпродуктами</a>
                <a href="#">Из рыбы и морепродуктов</a>
                <a href="#">Грибные</a>
                <a href="#">Овощные</a>
                <a href="#">С пастой (макаронами)</a>
                <a href="#">С фасолью</a>
                <a href="#">Фруктовые</a>
                <a href="#">Прочие салаты</a>
                <p></p>
                <b><a href="#">Соусы</a></b>
                <a href="#">Майонез</a>
                <a href="#">Острые</a>
                <a href="#">Сладкие</a>
                <a href="#">На основе яиц и молока</a>
                <a href="#">Томатные соусы</a>
                <a href="#">Соусы с уксусом</a>
                <a href="#">Дипы</a>
                <a href="#">Ореховые соусы</a>
                <a href="#">Соусы РУ</a>
                <a href="#">Соусы из ягод и фруктов</a>
                <a href="#">Грибные соусы</a>
                <a href="#">Соусы для пасты</a>
                <a href="#">Заправки</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Вторые блюда</a></b>
                <a href="#">Из мяса</a>
                <a href="#">Из птицы</a>
                <a href="#">Из фарша</a>
                <a href="#">Субпродукты</a>
                <a href="#">Рыба и морепродукты</a>
                <a href="#">Запеканки</a>
                <a href="#">Домашняя колбаса</a>
                <a href="#">В горшочках</a>
                <a href="#">Пельмени, вареники</a>
                <a href="#">Паста</a>
                <a href="#">Клецки, галушки</a>
                <a href="#">Овощи, грибы</a>
                <a href="#">Каши</a>
                <p></p>
                <b><a href="#">Супы</a></b>
                <a href="#">Борщи</a>
                <a href="#">Мясные супы</a>
                <a href="#">Рыбные супы</a>
                <a href="#">Сырные супы</a>
                <a href="#">Крем-супы</a>
                <a href="#">Супы из морепродуктов</a>
                <a href="#">Холодные супы</a>
                <a href="#">Рассольники</a>
                <a href="#">Грибные супы</a>
                <a href="#">Супы с фасолью</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Заготовки</a></b>
                <a href="#">Из овощей</a>
                <a href="#">Из ягод, фруктов</a>
                <a href="#">Заморозка</a>
                <a href="#">Из мяса</a>
                <a href="#">Компоты</a>
                <a href="#">Маринование</a>
                <p></p>
                <b><a href="#">Десерты</a></b>
                <a href="#">Желе и муссы</a>
                <a href="#">Безе</a>
                <a href="#">Мороженое</a>
                <a href="#">Творожные</a>
                <a href="#">С фруктами</a>
                <a href="#">Конфеты</a>
                <a href="#">Крем-брюлле</a>
                <a href="#">Торты</a>
                <a href="#">Из шоколада</a>
                <a href="#">Мармелад</a>

                <p></p>
                <b><a href="#">Выпечка</a></b>
                <a href="#">Тесто</a>
                <a href="#">Сладкая выпечка</a>
                <a href="#">Несладкая выпечка</a>
                <a href="#">Блины, оладьи</a>
                <a href="#">Выпечка из творога</a>
                <a href="#">Из слоеного теста</a>
            </div>
            <div class="footer_col">
                <b><a href="#">О проекте</a></b>
                <a href="#">Реклама на сайте</a>
                <a href="#">Рецепты блюд</a>
                <a href="#">Статьи</a>
                <a href="#">Кухни мира</a>
                <a href="#">Ингредиенты</a>
                <a href="#">Диеты для худеющих</a>
                <a href="#">Кулинарный форум</a>
                <p></p>
                <b><a href="#">Мы в соц.сетях</a></b>
                <a href="#">Инстраграмм</a>
                <a href="#">Вконтакте</a>
                <a href="#">Facebook</a>
                <a href="#">Одноклассники</a>
                <p></p>
                <b><a href="#">Полезное кулинару</a></b>
                <a href="#">Таблица мер и весов</a>
                <a href="#">Описание частей мяса</a>
                <a href="#">Правила разделки тушек</a>
                <a href="#">Правила очистки овощей</a>
                <a href="#">Способы нарезки</a>
            </div>
HTML;

    private const DIRECT_AFTER_CATEGORIES = <<<HTML
<a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
                <div class="direct_rasp"></div>
                <a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
                <div class="direct_rasp"></div>
                <a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
HTML;

}