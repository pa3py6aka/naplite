<?php

namespace backend\controllers;


use core\access\Rbac;
use core\components\Settings\EmailSettingsForm;
use core\components\Settings\MainSettingsForm;
use core\components\Settings\NotificationsSettingsForm;
use Yii;
use yii\base\Model;
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
        $form = new MainSettingsForm();
        if ($r = $this->saveForm($form, 'index')) {
            return $r;
        }

        return $this->render('index', [
            'model' => $form
        ]);
    }

    public function actionNotifications()
    {
        $form = new NotificationsSettingsForm();
        if ($r = $this->saveForm($form, 'notifications')) {
            return $r;
        }

        return $this->render('notifications', [
            'model' => $form
        ]);
    }

    public function actionEmails()
    {
        $form = new EmailSettingsForm();
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

        if ($r = $this->saveForm($form, 'emails')) {
            return $r;
        }

        return $this->render('emails', [
            'value' => $value ?: $current,
            'mailForm' => $form,
        ]);
    }

    private function saveForm(Model $form, $view)
    {
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if (Yii::$app->settings->saveForm($form)) {
                Yii::$app->session->setFlash("success", "Настройки успешно сохранены");
                return $this->redirect([$view]);
            }
        }
        return null;
    }
}