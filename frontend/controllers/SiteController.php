<?php
namespace frontend\controllers;

use core\forms\ContactForm;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionContact()
    {
        $form = new ContactForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $sent = Yii::$app->mailer->compose(['text' => 'contact-text', 'html' => 'contact-html'], ['form' => $form])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo(Yii::$app->settings->get('contactEmail'))
                ->setSubject('Сообщение с формы обратной связи ' . Yii::$app->name)
                ->send();

            if ($sent) {
                Yii::$app->session->setFlash('success', [['Сообщение отправлено', 'Ваше сообщение успешно отправлено администратору сайта.']]);
                return $this->redirect(Yii::$app->homeUrl);
            }

            Yii::$app->session->setFlash('error', [['Ошибка', 'Возникла ошибка при отправке сообщения, попробуйте позже.']]);
        }

        return $this->render('contact', [
            'model' => $form,
        ]);
    }

    public function actionPrivatePolicy()
    {
        return $this->render('private-policy');
    }
}
