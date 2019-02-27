<?php
namespace frontend\controllers;

use core\entities\Recipe\Recipe;
use core\repositories\CollectionRepository;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $recipesQuery = Recipe::find()
            ->with('mainPhotoEntity', 'author', 'recipePhotos')
            ->orderBy(['id' => SORT_DESC])
            ->active();
        $provider = new ActiveDataProvider([
            'query' => $recipesQuery,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSize' => 9],
        ]);

        /* @var $collectionRepository CollectionRepository */
        $collectionRepository = \Yii::$container->get(CollectionRepository::class);
        $collections = $collectionRepository->getBySort(12);

        return $this->render('index', [
            'recipes' => $provider->getModels(),
            'collections' => $collections,
        ]);
    }
}
