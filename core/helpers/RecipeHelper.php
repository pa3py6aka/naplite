<?php

namespace core\helpers;


use core\entities\Ingredient\Ingredient;
use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeIngredient;
use core\entities\Uom;
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

    public static function getUom(RecipeIngredient $ingredient)
    {
        if (!$ingredient->quantity) {
            return $ingredient->uom_id ? $ingredient->uomEntity->name : $ingredient->uom;
        }
        return $ingredient->uom_id ? Pluralize::get($ingredient->quantity, $ingredient->getUomForm(1), $ingredient->getUomForm(2), $ingredient->getUomForm(5), true) : Html::encode($ingredient->uom);
    }

    public static function getUomAutocompleteData()
    {
        $uoms = Uom::find()
            ->select(['name', 'f2', 'f5'])
            ->asArray()
            ->all();

        $data = [];
        foreach ($uoms as $uom) {
            $data['f1'][] = ['value' => $uom['name'], 'label' => $uom['name']];
            $data['f2'][] = ['value' => $uom['f2'] ?: $uom['name'], 'label' => $uom['f2'] ?: $uom['name']];
            $data['f5'][] = ['value' => $uom['f5'] ?: $uom['name'], 'label' => $uom['f5'] ?: $uom['name']];
            $data['js1'][] = $uom['name'];
            $data['js2'][] = $uom['f2'] ?: $uom['name'];
            $data['js5'][] = $uom['f5'] ?: $uom['name'];
        }
        //\Yii::trace($data, "MAIN PLURALIZATION DATA");

        return $data;
    }

    public static function getPluralizedData($int, $data)
    {
        $f = Pluralize::get($int, 'f1', 'f2', 'f5', true);
        //\Yii::trace($data[$f], "PLURALIZATION DATA");
        return $data[$f];
    }
}