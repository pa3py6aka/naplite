<?php

namespace frontend\controllers;


use core\repositories\CollectionRepository;
use yii\base\Module;
use yii\web\Controller;

class CollectionsController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, CollectionRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionView($slug)
    {
        $collection = $this->repository->getBySlug($slug);
        $recipesProvider = $this->repository->getRecipesProvider($collection);

        return $this->render('index', [
            'collection' => $collection,
            'recipesProvider' => $recipesProvider,
        ]);
    }
}