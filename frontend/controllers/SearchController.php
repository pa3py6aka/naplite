<?php

namespace frontend\controllers;


use core\entities\Recipe\Recipe;
use core\repositories\RecipeRepository;
use Yii;
use yii\base\Module;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

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

    public function actionAutoComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return ['result' => 'error'];
        }

        $value = trim(Yii::$app->request->get('value'));
        $recipes = Recipe::find()
            ->where(['like', 'name', $value])
            ->limit(10)
            ->all();

        $result = [];
        foreach ($recipes as $recipe) {
            /* @var $recipe Recipe */
            $result[] = '<a href="' . $recipe->url . '" class="tcell"><img class="thumb" src="' . $recipe->getMainPhoto(true) . '"></a>'
                . '<div class="tcell">'
                . '<h4><a href="' . $recipe->url . '" class="link">' . Html::encode($recipe->name) . '</a></h4>'
                . '<span class="fa fa-heart"></span> ' . $recipe->favorites_count
                . ' <span class="fa fa-star"></span> ' . $recipe->rate
                . ' <span class="fa fa-commenting-o"></span> ' . $recipe->comments_count
                . '<div class="author">Автор: <a class="ava-name" href="' . $recipe->author->pageUrl . '">' . $recipe->author->fullName . '</a></div>'
                . '</div>';
        }

        return $result;
    }
}