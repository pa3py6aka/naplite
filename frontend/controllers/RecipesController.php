<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\entities\Recipe;
use core\entities\RecipeUserRate;
use core\forms\CommentForm;
use core\forms\RecipeForm;
use core\repositories\NotFoundException;
use core\repositories\RecipeRepository;
use core\services\CommentService;
use core\services\RecipeService;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Yii;
use yii\base\Module;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\validators\ImageValidator;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class RecipesController extends Controller
{
    private $service;
    private $repository;

    public function __construct($id, Module $module, RecipeService $service, RecipeRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['new', 'upload', 'rate', 'edit', 'save-to-user'],
                'rules' => [
                    [
                        'actions' => ['new', 'upload', 'rate', 'edit', 'save-to-user'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                    'rate' => ['post'],
                    'save-to-user' => ['post'],
                ],
            ],
        ];
    }

    public function actionNew()
    {
        $form = new RecipeForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $recipe = $this->service->create($form);
                return $this->redirect(['view', 'id' => $recipe->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('message', $e->getMessage());
            }
        }

        return $this->render('new', [
            'model' => $form,
            'recipe' => null,
        ]);
    }

    public function actionEdit($id)
    {
        $recipe = $this->repository->get($id);
        if (!Yii::$app->user->can(Rbac::PERMISSION_MANAGE, ['user_id' => $recipe->id])) {
            throw new ForbiddenHttpException("Вы не можете редактировать эту статью.");
        }

        $form = new RecipeForm($recipe);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($recipe, $form);
                return $this->redirect(['view', 'id' => $recipe->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('message', $e->getMessage());
            }
        }

        return $this->render('new', [
            'model' => $form,
            'recipe' => $recipe,
        ]);
    }

    public function actionView($id)
    {
        $recipe = $this->repository->get($id);
        $commentForm = new CommentForm();

        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {
            /* @var $commentService CommentService */
            $commentService = Yii::$container->get(CommentService::class);
            $commentService->addComment($commentForm, $recipe);
            $commentForm = new CommentForm();
        }

        return $this->render('view', [
            'recipe' => $recipe,
            'commentModel' => $commentForm,
        ]);
    }

    public function actionIndex()
    {
        throw new UserException("Страница не найдена в вёрстке");
    }

    public function actionRate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $value = (int) Yii::$app->request->post('value');
        $id = (int) Yii::$app->request->post('id');
        if ($recipe = Recipe::findOne($id)) {
            if (!$recipeUserRate = RecipeUserRate::find()->where(['recipe_id' => $id, 'user_id' => Yii::$app->user->id])->limit(1)->one()) {
                $recipeUserRate = new RecipeUserRate([
                    'recipe_id' => $id,
                    'user_id' => Yii::$app->user->id,
                    'value' => $value
                ]);
            } else {
                $recipeUserRate->value = $value;
            }

            if ($recipeUserRate->save()) {
                $rate = RecipeUserRate::find()->where(['recipe_id' => $id])->sum('value');
                $recipe->rate = $rate;
                if ($recipe->save()) {
                    return ['result' => 'success', 'rate' => $rate];
                }
            }
        }

        return ['result' => false];
    }

    public function actionSaveToUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $recipeId = (int) Yii::$app->request->post('recipeId');
        $userId = Yii::$app->user->id;

        try {
            $result = $this->service->saveToUser($userId, $recipeId);
        } catch (\DomainException $e) {
            return ['result' => false, 'error' => $e->getMessage()];
        }

        return ['result' => 'success', 'html' => $result ? '<i class="fa fa-minus"></i>Убрать из избранных' : '<i class="fa fa-plus"></i>Сохранить рецепт'];
    }

    public function actionPrint($id)
    {
        $recipe = $this->repository->get($id);
        return $this->renderPartial('print', ['recipe' => $recipe]);
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $validator = new ImageValidator([
            'extensions' => 'jpg, jpeg, gif, png',
            'maxSize' => Yii::$app->params['maxUploadFileSize'],
            'tooBig' => "Размер фото не должен превышать " . Yii::$app->params['maxUploadFileSizeHuman'],
            'wrongExtension' => 'Недопустимый формат файла'
        ]);
        $files = UploadedFile::getInstancesByName('file');
        $num = Yii::$app->request->post('num', 0);

        $result = [];
        foreach ($files as $file) {
            if (!$validator->validate($file, $error)) {
                return ['result' => 'error', 'message' => $error];
            }
            $name = md5(Yii::$app->user->id . Yii::$app->security->generateRandomString(64)) . "." . $file->extension;
            $editName = pathinfo($name, PATHINFO_FILENAME) . '_e.' . pathinfo($name, PATHINFO_EXTENSION);
            $result[$num] = ['name' => $name, 'editName' => $editName];

            $path = Yii::getAlias('@tmp/');
            if (!$file->saveAs($path . $name)) {
                Yii::error("Ошибка при сохранении временного файла, файл " . $name . ", RecipesController->actionUpload()");
                return ['result' => 'error', 'message' => "Ошибка при соранении файла"];
            }

            if (Yii::$app->request->post('type') == 'recipe') {
                Yii::$app->photoSaver->createRecipeImages($path . $name);
            } else {
                Yii::$app->photoSaver->createStepImage($path . $name);
            }

            $num++;
        }

        return ['result' => 'success', 'files' => $result];
    }
}