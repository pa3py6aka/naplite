<?php

namespace frontend\controllers;


use core\forms\auth\LoginForm;
use core\entities\User\User;
use core\access\Rbac;
use core\services\RoleManager;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use core\forms\auth\SignupForm;
use core\services\TransactionManager;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AuthController extends Controller
{
    private $roleManager;

    public function __construct($id, Module $module, RoleManager $roleManager, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->roleManager = $roleManager;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'confirm', 'signup-validation', 'login', 'login-validation'],
                'rules' => [
                    [
                        'actions' => ['signup', 'signup-validation', 'confirm', 'login', 'login-validation'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        throw new UserException('Ошибка при входе.');
    }

    public function actionLoginValidation()
    {
        $form = new LoginForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        return "";
    }

    public function actionSignup()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $sent = false;
                (new TransactionManager())->wrap(function () use ($form, &$sent) {
                    $user = User::signupRequest($form->email, $form->password);
                    if ($user->save()) {
                        $sent = Yii::$app->mailer->compose(
                            ['html' => 'emailConfirmation-html', 'text' => 'emailConfirmation-text'],
                            ['user' => $user]
                        )
                            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                            ->setTo($user->email)
                            ->setSubject('Подтверждение регистрации на сайте ' . Yii::$app->name)
                            ->send();

                        if (!$sent) {
                            throw new \DomainException('Ошибка отправки e-mail');
                        }
                    }
                });
            } catch (\DomainException $e) {
                throw new UserException($e);
            }
            return $this->redirect(['/main/index', 'signup' => 'ok']);
        }

        return $this->redirect(['/main/index', 'signup' => 'error']);
    }

    public function actionSignupValidation()
    {
        $form = new SignupForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        return '';
    }

    public function actionConfirm($token)
    {
        if (empty($token)) {
            throw new UserException('Пустой токен.');
        }

        $user = User::find()->where(['email_confirm_token' => $token, 'status' => User::STATUS_WAIT])->one();
        if (!$user) {
            throw new UserException('Пользователь с таким токеном не найден!');
        }

        $user->confirmSignup();
        if ($user->save()) {
            $this->roleManager->assign($user->id, Rbac::ROLE_USER);
            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            Yii::$app->session->setFlash('confirm-success', 'Ваш адрес e-mail успешно подтверждён!');
            return $this->redirect(['/users/settings']);
        }
        throw new UserException('Ошибка сохранения в базу, обратитесь в службу поддержки!');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Requests password reset.
     * @return mixed
     * @throws UserException
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                throw new UserException("На Ваш адрес электронной почты отправлена ссылка для восстановления пароля");
            }
            throw new UserException("Извините, мы не можем отослать ссылку для восстановления пароля, возможно она уже была отправлена ранее.");
        }

        throw new UserException("Ошибка при восстановлении пароля.");
    }

    public function actionRequestPasswordResetValidation()
    {
        $form = new PasswordResetRequestForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        return "";
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws UserException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            throw new UserException("Новый пароль успешно установлен.");
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}