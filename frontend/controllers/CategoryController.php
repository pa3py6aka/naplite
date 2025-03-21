<?php

namespace frontend\controllers;


use core\helpers\CategoryHelper;
use core\repositories\CategoryRepository;
use yii\base\Module;
use yii\web\Controller;

class CategoryController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, CategoryRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionView($slug = 'root')
    {
        $category = $this->repository->getBySlug($slug);
        $recipesProvider = $this->repository->getRecipesProviderByCategory($category);
        $this->view->params['activeCategorySlug'] = CategoryHelper::getActiveSlug($category);

        if ($category->depth <= 1) {
            return $this->render('category-base', [
                'category' => $category,
                'recipesProvider' => $recipesProvider,
            ]);
        }

        return $this->render('sub-category', [
            'category' => $category,
            'recipesProvider' => $recipesProvider,
        ]);
    }
}