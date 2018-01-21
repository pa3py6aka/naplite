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
    ];

    public function __construct()
    {
        $this->settings = Json::decode(file_get_contents($this->file));
        $this->prepare();
    }

    public function get($param)
    {
        if (isset($this->settings[$param])) {
            return $this->settings[$param];
        }
        return null;
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
            if (!isset($this->settings[$param])) {
                $this->settings[$param] = $value;
            }
        }
    }
}