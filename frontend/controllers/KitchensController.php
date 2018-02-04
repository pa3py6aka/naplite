<?php

namespace frontend\controllers;


use core\entities\Kitchen;
use core\repositories\NotFoundException;
use core\repositories\RecipeRepository;
use Yii;
use yii\web\Controller;

class KitchensController extends Controller
{
    public function actionIndex()
    {
        $kitchens = Kitchen::find()->orderBy(['name' => SORT_ASC])->all();

        return $this->render('index', [
            'kitchens' => $kitchens,
        ]);
    }

    public function actionView($slug)
    {
        if (!$kitchen = Kitchen::find()->where(['slug' => $slug])->one()) {
            throw new NotFoundException("Кухня мира не найдена");
        }

        $recipesProvider = (new RecipeRepository())->getRecipesByKitchenId($kitchen->id);

        return $this->render('view', [
            'kitchen' => $kitchen,
            'recipesProvider' => $recipesProvider,
        ]);
    }
}