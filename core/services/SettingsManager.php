<?php

namespace core\services;


use yii\helpers\Json;

class SettingsManager
{
    private $settings;

    /* @note Don't change keys in this array!!! */
    private $default = [
        'recipeIntroductoryTextMaxLength' => 500,
    ];

    public function __construct()
    {
        $this->settings = Json::decode(file_get_contents(__DIR__ . '/../settings.json'));
        $this->prepare();
    }

    public function get($param)
    {
        if (isset($this->settings[$param])) {
            return $this->settings[$param];
        }
        return null;
    }

    public function getAll()
    {
        return $this->settings;
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