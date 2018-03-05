<?php

namespace frontend\controllers;


use core\entities\Ingredient\Ingredient;
use core\entities\Ingredient\IngredientCategory;
use core\forms\CommentForm;
use core\repositories\IngredientCategoryRepository;
use core\repositories\IngredientRepository;
use core\services\CommentService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Response;

class IngredientsController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, IngredientRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionIndex($category = false)
    {
        if ($category) {
            /* @var $categoryRepository IngredientCategoryRepository */
            $categoryRepository = Yii::$container->get(IngredientCategoryRepository::class);
            $category = $categoryRepository->getBySlug($category);
        } else {
            $category = IngredientCategory::find()->where(['id' => 1])->limit(1)->one();
        }

        $search = Yii::$app->request->get('search', '');
        $ingredientsProvider = $this->repository->getProvider($category, $search);

        return $this->render('index', [
            'ingredientsProvider' => $ingredientsProvider,
            'category' => $category,
            'search' => $search,
        ]);
    }

    public function actionView($id)
    {
        $ingredient = $this->repository->get($id);

        $commentForm = new CommentForm();
        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {
            /* @var $commentService CommentService */
            $commentService = Yii::$container->get(CommentService::class);
            $commentService->addComment($commentForm, $ingredient);
            $commentForm = new CommentForm();
        }

        return $this->render('view', [
            'ingredient' => $ingredient,
            'commentModel' => $commentForm,
        ]);
    }

    public function actionAutoComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return ['result' => 'error'];
        }

        $value = trim(Yii::$app->request->get('value'));
        $result = Ingredient::find()
            ->select(['title'])
            ->where(['like', 'title', $value])
            ->column();

        return $result;
    }
}