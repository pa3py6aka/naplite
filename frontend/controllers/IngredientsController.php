<?php

namespace frontend\controllers;


use core\entities\Ingredient\IngredientCategory;
use core\repositories\IngredientCategoryRepository;
use core\repositories\IngredientRepository;
use Yii;
use yii\base\Module;
use yii\web\Controller;

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

        return $this->render('view', [
            'ingredient' => $ingredient,
        ]);
    }
}