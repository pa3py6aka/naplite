<?php

namespace backend\controllers;


use core\forms\manage\SettingsForm;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $form = new SettingsForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {

        }

        return $this->render('index', [
            'model' => $form
        ]);
    }
}