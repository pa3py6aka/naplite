<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\forms\User\ChangePasswordForm;
use core\forms\User\UserSettingsForm;
use core\repositories\UserRepository;
use core\services\UserService;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UsersController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, Module $module, UserRepository $repository, UserService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['settings'],
                'rules' => [
                    [
                        'actions' => ['settings', 'change-password-validation'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'change-password-validation' => ['post'],
                ],
            ],
        ];
    }

    public function actionSettings()
    {
        $user = Yii::$app->user->identity;
        $form = new UserSettingsForm($user);
        $changePasswordForm = new ChangePasswordForm($user);

        if ($form->load(Yii::$app->request->post())) {
            if (!$form->validate()) {
                Yii::$app->session->setFlash('error', [['Ошибка', implode('<br />', $form->getFirstErrors())]]);
            } else {
                try {
                    $this->service->edit($form, $user);
                    Yii::$app->session->setFlash('success', [['Сохранено', 'Настройки успешно сохранены']]);
                } catch (\DomainException $e) {
                    Yii::$app->session->setFlash('error', [['Ошибка', $e->getMessage()]]);
                }
            }
        }

        if ($changePasswordForm->load(Yii::$app->request->post()) && $changePasswordForm->validate()) {
            try {
                $user->setPassword($changePasswordForm->newPassword);
                $this->repository->save($user);
                Yii::$app->session->setFlash('success', [['Сохранено', 'Новый пароль установлен']]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', [['Ошибка', $e->getMessage()]]);
            }
        }

        return $this->render('settings', [
            'user' => $user,
            'model' => $form,
            'changePasswordModel' => $changePasswordForm,
        ]);
    }

    public function actionChangePasswordValidation()
    {
        $form = new ChangePasswordForm(Yii::$app->user->identity);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        return "";
    }
}