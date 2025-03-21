<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\entities\Recipe\Recipe;
use core\entities\Recipe\RecipeUserRate;
use core\entities\User\UserRecipe;
use core\forms\CommentForm;
use core\forms\RecipeForm;
use core\helpers\CategoryHelper;
use core\repositories\RecipeRepository;
use core\services\CommentService;
use core\services\RecipeService;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\validators\ImageValidator;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
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
                'only' => ['new', 'upload', 'rate', 'edit', 'save-to-user', 'crop', 'remove'],
                'rules' => [
                    [
                        'actions' => ['new', 'upload', 'rate', 'edit', 'save-to-user', 'crop', 'remove'],
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
                    'get-sub-categories' => ['post'],
                    'crop' => ['post'],
                    'remove' => ['post'],
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
                return $this->redirect(['view', 'slug' => $recipe->slug]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('message', $e->getMessage());
            }
        }

        return $this->render('new', [
            'model' => $form,
            'recipe' => null,
        ]);
    }

    public function actionEdit($slug)
    {
        $recipe = $this->repository->getBySlug($slug);
        if (!Yii::$app->user->can(Rbac::PERMISSION_MANAGE, ['user_id' => $recipe->author_id])) {
            throw new ForbiddenHttpException('Вы не можете редактировать этот рецепт.');
        }

        $form = new RecipeForm($recipe);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($recipe, $form);
                return $this->redirect(['view', 'slug' => $recipe->slug]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('message', $e->getMessage());
            }
        }

        return $this->render('new', [
            'model' => $form,
            'recipe' => $recipe,
        ]);
    }

    public function actionRemove($slug)
    {
        $recipe = $this->repository->getBySlug($slug);
        if (!Yii::$app->user->can(Rbac::PERMISSION_MANAGE, ['user_id' => $recipe->author_id])) {
            throw new ForbiddenHttpException('Вы не можете удалить этот рецепт.');
        }

        $recipe->status = Recipe::STATUS_DELETED;
        if (!$recipe->save()) {
            throw new \RuntimeException('Ошибка установки рецепту статуса "удалён".');
        }
        Yii::$app->session->setFlash('success', 'Рецепт удалён.');
        return $this->redirect(['/users/recipes', 'id' => Yii::$app->user->id]);
    }

    public function actionView($slug)
    {
        $recipe = $this->repository->getBySlug($slug);
        if ($recipe->status != Recipe::STATUS_ACTIVE && $recipe->author_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('Рецепт не найден.');
        }
        $this->view->params['activeCategorySlug'] = CategoryHelper::getActiveSlug($recipe->category);
        $commentForm = new CommentForm();
        $photoReports = $recipe->getPhotoReports()->with('user')->orderBy(['id' => SORT_DESC])->limit(5)->all();
        if (!Yii::$app->user->isGuest) {
            $isFavorite = UserRecipe::find()->where(['recipe_id' => $recipe->id, 'user_id' => Yii::$app->user->id])->exists();
        } else {
            $isFavorite = false;
        }

        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {
            /* @var $commentService CommentService */
            $commentService = Yii::$container->get(CommentService::class);
            $commentService->addComment($commentForm, $recipe);
            return $this->redirect($recipe->getUrl(false, 'comments'));
        }

        return $this->render('view', [
            'recipe' => $recipe,
            'commentModel' => $commentForm,
            'photoReports' => $photoReports,
            'isFavorite' => $isFavorite,
        ]);
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

        return [
            'result' => 'success',
            'html' => $result ? '<i class="fa fa-minus"></i>Убрать из избранных' : '<i class="fa fa-plus"></i>Сохранить рецепт',
            'count' => Recipe::find()->select(['favorites_count'])->where(['id' => $recipeId])->scalar(),
        ];
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
            $fileName = md5(Yii::$app->user->id . Yii::$app->security->generateRandomString(64));
            $name = $fileName . "." . $file->extension;
            $editName = $fileName . '_e.' . $file->extension;
            $result[$num] = ['name' => $name, 'editName' => $editName];

            $path = Yii::getAlias('@tmp/');
            if (!$file->saveAs($path . $name) || !copy($path . $name, $path . $editName)) {
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

    public function actionCrop()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $x = (int) Yii::$app->request->post('x');
        $y = (int) Yii::$app->request->post('y');
        $width = (int) Yii::$app->request->post('width');
        $height = (int) Yii::$app->request->post('height');
        $url = Yii::$app->request->post('url');

        $dir = pathinfo($url, PATHINFO_DIRNAME) . '/';
        $path = Yii::getAlias('@frontend/web') . '/' . $dir;
        $eNameBase = pathinfo($url, PATHINFO_FILENAME);
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $baseName = substr($eNameBase, 0, -2) . "." . $ext;
        $eName = $eNameBase . "." . $ext;
        if (!$url || !is_file($path . $eName)) {
            return ['result' => 'error', 'error' => 'Файл ' . $eName . ' не найден'];
        }

        Yii::$app->photoSaver->crop($path . $eName, $width, $height, $x, $y, $path . $baseName);
        Yii::$app->photoSaver->createRecipeImages($path . $baseName);

        return ['result' => 'success', 'url' => '/tmp/' . $baseName . '?v=' . time()];
    }

    public function actionGetSubCategories()
    {
        $id = (int) Yii::$app->request->post('id');
        return $this->asJson(RecipeForm::childCategoriesList($id));
    }
}