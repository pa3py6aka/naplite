<?php
namespace frontend\controllers;

use core\entities\Recipe;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $recipesQuery = Recipe::find()->orderBy(['id' => SORT_DESC]);
        $provider = new ActiveDataProvider([
            'query' => $recipesQuery,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSize' => 9],
        ]);

        return $this->render('index', [
            'recipes' => $provider->getModels(),
        ]);
    }
}
