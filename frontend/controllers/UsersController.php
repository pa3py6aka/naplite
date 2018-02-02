<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\entities\Recipe\Category;
use core\entities\Recipe\Recipe;
use core\forms\User\ChangePasswordForm;
use core\forms\User\UserSettingsForm;
use core\repositories\CategoryRepository;
use core\repositories\RecipeRepository;
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
    private $userRepository;
    private $service;
    private $recipeRepository;

    public function __construct(
        $id,
        Module $module,
        UserRepository $userRepository,
        UserService $service,
        RecipeRepository $recipeRepository,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->recipeRepository = $recipeRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['view'],
                'rules' => [
                    [
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

    public function actionView($id)
    {
        $user = $this->userRepository->get($id);
        $recipesProvider = $this->userRepository->getRecipesProviderByUserId($id);

        return $this->render('view', [
            'user' => $user,
            'recipesProvider' => $recipesProvider,
        ]);
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
                $this->userRepository->save($user);
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

    public function actionCookbook($category = null)
    {
        $userId = Yii::$app->user->id;
        $category = $category ? (new CategoryRepository())->getBySlug($category) : null;
        $provider = $this->recipeRepository->getUserFavoriteRecipes($userId, $category);
        $userCategories = Category::find()
            ->alias('c')
            ->leftJoin('{{%recipes}} r', 'r.category_id=c.id')
            ->leftJoin('{{%user_recipes}} ur', 'ur.recipe_id=r.id')
            ->andWhere(['ur.user_id' => $userId, 'r.status' => Recipe::STATUS_ACTIVE])
            ->all();

        return $this->render('cookbook', [
            'provider' => $provider,
            'category' => $category,
            'userId' => $userId,
            'userCategories' => $userCategories,
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