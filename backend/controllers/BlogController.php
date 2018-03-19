<?php

namespace backend\controllers;

use core\forms\BlogForm;
use core\repositories\BlogRepository;
use core\services\BlogService;
use Yii;
use core\entities\Blog\Blog;
use backend\forms\BlogSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    private $service;
    private $repository;

    public function __construct($id, Module $module, BlogService $service, BlogRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => Yii::$app->params['frontendHostInfo'] . '/uploads/i/', // Directory URL address, where files are stored.
                'path' => '@frontend/web/uploads/i', // Or absolute path to directory where files are stored.
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new BlogForm();
        $model = new Blog();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $blog = $this->service->create($form);
                return $this->redirect(['view', 'id' => $blog->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::trace($model->errors, 'ERRORS');
        }

        return $this->render('create', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAutoComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return ['result' => 'error'];
        }

        $value = trim(Yii::$app->request->get('value'));
        $users = Blog::find()
            ->select(['title'])
            ->where(['like', 'title', $value])
            ->column();

        return $users;
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
