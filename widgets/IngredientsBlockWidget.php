<?php

namespace widgets;


use core\entities\Ingredient\Ingredient;
use yii\base\Widget;

class IngredientsBlockWidget extends Widget
{
    public $currentIngredientId;

    public function run()
    {
        $count = Ingredient::find()->andWhere(['show' => 1])->count();
        $offset = mt_rand(0, $count);
        $offset = $offset > $count - 4 ? $count - 4 : $offset;
        $ingredients = Ingredient::find()
            ->andWhere(['show' => 1])
            ->indexBy('id')
            ->orderBy(['id' => SORT_DESC])
            ->offset($offset)
            ->limit(3)
            ->all();

        if ($this->currentIngredientId && isset($ingredients[$this->currentIngredientId])) {
            unset($ingredients[$this->currentIngredientId]);
            $ingredient = Ingredient::find()
                ->where(['not', ['id' => array_merge(array_keys($ingredients), [$this->currentIngredientId])]])
                ->andWhere(['show' => 1])
                ->limit(1)
                ->one();
            if ($ingredient) {
                array_push($ingredients, $ingredient);
            }
        }

        return $this->render('ingredients-block', [
            'ingredients' => $ingredients,
        ]);
    }
}