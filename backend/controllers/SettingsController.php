<?php

namespace backend\controllers;


use core\access\Rbac;
use core\components\Settings\SettingsForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
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

    public function actionEmails()
    {
        $value = Yii::$app->request->post('value');
        $current = file_get_contents(Yii::$app->settings->emails);

        if ($value) {
            $new = str_replace('{TITLE}', '<?= Html::encode($this->title) ?>', $value);
            $new = str_replace('{CONTENT}', '<?= $content ?>', $new);
            $tmp = file_get_contents(Yii::getAlias('@common/mail/layouts/html-template.php'));
            $tmp = str_replace('<--BODY-->', $new, $tmp);
            file_put_contents(Yii::getAlias('@common/mail/layouts/html.php'), $tmp);
            file_put_contents(Yii::$app->settings->emails, $value);

            Yii::$app->session->setFlash("success", "Шаблон сохранён");
        }

        return $this->render('emails', [
            'value' => $value ?: $current,
        ]);
    }
}