<?php

namespace frontend\controllers;


use core\entities\Article\ArticleCategory;
use core\entities\Category;
use core\forms\CommentForm;
use core\repositories\ArticleCategoryRepository;
use core\repositories\ArticleRepository;
use core\services\CommentService;
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

    public function actionIndex($category = false)
    {
        if ($category) {
            /* @var $categoryRepository ArticleCategoryRepository */
            $categoryRepository = Yii::$container->get(ArticleCategoryRepository::class);
            $category = $categoryRepository->getBySlug($category);
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

    public function actionView($slug)
    {
        $article = $this->repository->getBySlug($slug);

        $commentForm = new CommentForm();
        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {
            /* @var $commentService CommentService */
            $commentService = Yii::$container->get(CommentService::class);
            $commentService->addComment($commentForm, $article);
            $commentForm = new CommentForm();
        }

        return $this->render('view', [
            'article' => $article,
            'commentModel' => $commentForm,
        ]);
    }
}