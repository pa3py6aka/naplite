<?php

namespace frontend\controllers;


use core\entities\Weight;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WeightsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'load' => ['post'],
                ],
            ],
        ];
    }

    public function actionLoad()
    {
        $search = \Yii::$app->request->post('search');
        $query = Weight::find()->orderBy(['name' => SORT_ASC]);
        if ($search) {
            $query->where(['like', 'name', $search]);
        }
        $weights = $query->all();

        return $this->renderPartial('table', ['weights' => $weights]);
    }
}