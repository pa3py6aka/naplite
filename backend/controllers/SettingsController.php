<?php

namespace backend\controllers;


use core\access\Rbac;
use core\components\Settings\SettingsForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN]
                    ]
                ],
            ],
        ];
    }

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