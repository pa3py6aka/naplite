<?php

namespace backend\controllers;


use core\components\Settings\SettingsForm;
use Yii;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $form = new SettingsForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if (Yii::$app->settings->saveAll($form)) {
                Yii::$app->session->setFlash("success", "Настройки успешно сохранены");
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'model' => $form
        ]);
    }
}