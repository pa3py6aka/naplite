<?php

namespace core\helpers;


use core\entities\Recipe\Recipe;
use yii\helpers\Html;

class RecipeHelper
{
    public static function hoursFromMinutes($minutes)
    {
        if ($minutes < 60) {
            return $minutes . ' мин';
        }
        return round($minutes / 60, 1) . ' часа';
    }

    public static function getPhotosForCarousel(Recipe $recipe)
    {
        $items = [];
        foreach ($recipe->recipePhotos as $photo) {
            $items[] = [
                'content' => Html::img('/photos/' . $photo->file, ['width' => 860, 'height' => 560]),
                'caption' => '',//'<h1>Заголовок</h1><p>Какой-то дополнительный текст</p><p><a href="/article/link/1" class="btn btn-primary">Подробнее <span class="glyphicon glyphicon-chevron-right"></a></p>',
                'options' => []
            ];
        }
        return $items;
    }
}