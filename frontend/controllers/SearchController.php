<?php

namespace frontend\controllers;


use core\repositories\RecipeRepository;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class SearchController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, RecipeRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionIndex()
    {
        $search = Yii::$app->request->get('q');
        $provider = $search ? $this->repository->findRecipes($search) : null;

        return $this->render('index', [
            'provider' => $provider,
            'search' => $search,
        ]);
    }
}