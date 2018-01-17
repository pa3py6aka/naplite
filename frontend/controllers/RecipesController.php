<?php

namespace frontend\controllers;


use yii\web\Controller;

class RecipesController extends Controller
{
    public function actionNew()
    {
        return $this->render('new');
    }
}