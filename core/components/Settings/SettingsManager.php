<?php

namespace core\components\Settings;


use yii\helpers\Json;

class SettingsManager
{
    private $settings;
    public $file = __DIR__ . '/settings.json';

    /* @note Don't change keys in this array!!! */
    private $default = [
        'recipeIntroductoryTextMaxLength' => 500,
        'photoReportText' => 'Добавьте свой фотоотчёт о приготовленном блюде по данному рецепту',
        'widgetVK' => "VK.Widgets.Group('vk_groups', {
                mode: 3,
                width: 'auto',
                no_cover: 1,
                color1: '#ffffff'
            }, 20003922);",
        'instagramLogin' => 'prikol_tyt',
        'widgetFB' => '<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=true&appId=115551535801362" width="100%" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>',
    ];

    public function __construct()
    {
        $this->settings = Json::decode(file_get_contents($this->file));
        $this->prepare();
    }

    public function get($param)
    {
        if (isset($this->settings[$param])) {
            return $this->settings[$param] ?: $this->default[$param];
        }
        return $this->default[$param];
    }

    public function getAll(): array
    {
        return $this->settings;
    }

    public function saveAll(SettingsForm $form)
    {
        return file_put_contents($this->file, Json::encode($form->attributes));
    }

    private function prepare()
    {
        foreach ($this->default as $param => $value) {
            if (!isset($this->settings[$param]) || !$this->settings[$param]) {
                $this->settings[$param] = $value;
            }
        }
    }
}