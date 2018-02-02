<?php

namespace backend\controllers;

use core\access\Rbac;
use core\forms\User\ChangePasswordForm;
use core\services\RoleManager;
use Yii;
use core\entities\User\User;
use backend\forms\UserSearch;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'block' => ['POST'],
                    'assign' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionBlock($id)
    {
        $user = $this->findModel($id);

        if ($user->status != User::STATUS_DELETED && $this->canEdit($user->id)) {
            $user->status = User::STATUS_DELETED;
            if (!$user->save()) {
                Yii::$app->session->setFlash('error', 'Ошибка записи в базу');
            } else {
                /* @var $roleManager RoleManager */
                $roleManager = Yii::$container->get(RoleManager::class);
                $roleManager->assign($user->id, Rbac::ROLE_BLOCKED);
            }
        }

        return $this->redirect(['view', 'id' => $user->id]);
    }

    public function actionActivate($id)
    {
        $user = $this->findModel($id);

        if ($user->status != User::STATUS_ACTIVE && $this->canEdit($user->id)) {
            $user->status = User::STATUS_ACTIVE;
            if (!$user->save()) {
                Yii::$app->session->setFlash('error', 'Ошибка записи в базу');
            } else {
                $roles = Yii::$app->authManager->getRolesByUser($user->id);
                if (isset($roles[Rbac::ROLE_BLOCKED])) {
                    /* @var $roleManager RoleManager */
                    $roleManager = Yii::$container->get(RoleManager::class);
                    $roleManager->assign($user->id, Rbac::ROLE_USER);
                }
            }
        }

        return $this->redirect(['view', 'id' => $user->id]);
    }

    public function actionAssign($id, $role)
    {
        $user = $this->findModel($id);
        $role = $role == Rbac::ROLE_MODERATOR ? Rbac::ROLE_MODERATOR : Rbac::ROLE_USER;
        /* @var $roleManager RoleManager */
        $roleManager = Yii::$container->get(RoleManager::class);
        $roleManager->assign($user->id, $role);
        return $this->redirect(['view', 'id' => $user->id]);
    }

    public function actionChangePassword($id)
    {
        $user = $this->findModel($id);
        if (!$this->canEdit($user->id)) {
            throw new UserException("У вас нет полномочий для редактирования модераторов и администраторов");
        }

        $form = new ChangePasswordForm($user);
        $form->scenario = ChangePasswordForm::SCENARIO_MANAGE;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->setPassword($form->newPassword);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Новый пароль установлен');
                return $this->redirect(['view', 'id' => $user->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка сохранения в базу');
            }
        }

        return $this->render('change-password', ['model' => $form, 'user' => $user]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array
     */
    public function actionAutoComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return ['result' => 'error'];
        }

        $username = trim(Yii::$app->request->get('username'));
        $users = User::find()
            ->select(['username'])
            ->where(['like', 'username', $username])
            ->column();

        return $users;
    }

    private function canEdit($userId): bool
    {
        if (Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
            return true;
        }
        $roles = Yii::$app->authManager->getRolesByUser($userId);
        if (isset($roles[Rbac::ROLE_ADMIN]) || isset($roles[Rbac::ROLE_MODERATOR])) {
            return false;
        }
        return true;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
