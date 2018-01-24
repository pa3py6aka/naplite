<?php

namespace frontend\controllers;


use core\entities\Article\ArticleCategory;
use core\entities\Category;
use core\repositories\ArticleCategoryRepository;
use core\repositories\ArticleRepository;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class ArticlesController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, ArticleRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionIndex($slug = false)
    {
        if ($slug) {
            /* @var $categoryRepository ArticleCategoryRepository */
            $categoryRepository = Yii::$container->get(ArticleCategoryRepository::class);
            $category = $categoryRepository->getBySlug($slug);
        } else {
            $category = ArticleCategory::find()->where(['id' => 1])->limit(1)->one();
        }

        $search = Yii::$app->request->post('search', '');
        $articlesProvider = $this->repository->getProvider($category, $search);

        return $this->render('index', [
            'articlesProvider' => $articlesProvider,
            'category' => $category,
            'search' => $search,
        ]);
    }
}