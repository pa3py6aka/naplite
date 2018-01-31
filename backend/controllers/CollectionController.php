<?php

namespace backend\controllers;


use backend\forms\RecipeSearch;
use core\access\Rbac;
use core\entities\Recipe\Collection\Collection;
use core\entities\Recipe\Collection\CollectionRecipe;
use core\forms\manage\CollectionForm;
use core\repositories\CollectionRepository;
use core\services\manage\CollectionManageService;
use richardfan\sortable\SortableAction;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CollectionController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, Module $module, CollectionRepository $repository, CollectionManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'append' => ['POST'],
                    'un-select' => ['POST'],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'sort' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Collection::className(),
                'orderColumn' => 'sort',
            ],
        ];
    }

    public function actionIndex()
    {
        $collectionsProvider = $this->repository->getCollectionsProvider();

        return $this->render('index', [
            'collectionsProvider' => $collectionsProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new CollectionForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $collection = $this->service->create($form);
                return $this->redirect(['view', 'id' => $collection->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $collection = $this->repository->get($id);
        $form = new CollectionForm($collection);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($collection, $form);
                return $this->redirect(['view', 'id' => $collection->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'collection' => $collection
        ]);
    }

    public function actionView($id)
    {
        $collection = $this->repository->get($id);
        $selectedRecipesProvider = new ActiveDataProvider([
            'query' => $collection->getRecipes(),
            'pagination' => ['pageSize' => 20, 'defaultPageSize' => 20, 'pageParam' => 'sPage'],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]]
        ]);

        $searchModel = new RecipeSearch();
        $allRecipesProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('view', [
            'collection' => $collection,
            'selectedRecipesProvider' => $selectedRecipesProvider,
            'searchModel' => $searchModel,
            'allRecipesProvider' => $allRecipesProvider,
        ]);
    }

    public function actionAppend($id, $collectionId)
    {
        if (CollectionRecipe::find()->where(['recipe_id' => $id, 'collection_id' => $collectionId])->exists()) {
            Yii::$app->session->setFlash('error', 'Этот рецепт уже есть в подборке');
        } else {
            $collectionRecipe = new CollectionRecipe([
                'recipe_id' => $id,
                'collection_id' => $collectionId
            ]);
            if ($collectionRecipe->save()) {
                Yii::$app->session->setFlash('success', 'Рецепт добавлен в подборку');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при записи в базу');
            }
        }

        $link = str_replace('#all-articles', '', Yii::$app->request->referrer) . '#all-articles';
        return $this->redirect($link);
    }

    public function actionUnSelect($id, $collectionId)
    {
        if ($collectionRecipe = CollectionRecipe::find()->where(['recipe_id' => $id, 'collection_id' => $collectionId])->limit(1)->one()) {
            if ($collectionRecipe->delete()) {
                Yii::$app->session->setFlash('success', 'Рецепт удалён из подборки');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка удаления из базы');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Рецепт не найден в подборке');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}