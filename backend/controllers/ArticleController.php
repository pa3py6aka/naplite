<?php

namespace backend\controllers;

use core\access\Rbac;
use core\forms\manage\ArticleManageForm;
use core\repositories\ArticleRepository;
use core\services\manage\ArticleManageService;
use Yii;
use core\entities\Article\Article;
use backend\forms\ArticleSearch;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    private $repository;
    private $service;

    public function __construct(
        $id,
        Module $module,
        ArticleRepository $repository,
        ArticleManageService $service,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id === 'upload-image') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ArticleManageForm();
        $form->scenario = ArticleManageForm::SCENARIO_CREATE;

        if (is_file(Yii::getAlias('@data/article-template.html'))) {
            $form->content = file_get_contents(Yii::getAlias('@data/article-template.html'));
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $article = $this->service->create($form);
                return $this->redirect(['view', 'id' => $article->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $article = $this->findModel($id);
        $form = new ArticleManageForm($article);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($article->id, $form);
                return $this->redirect(['view', 'id' => $article->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'article' => $article,
        ]);
    }

    public function actionUploadImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $path = Yii::getAlias('@frontend/web/uploads/art/content');
        $file = UploadedFile::getInstanceByName('upload');
        $name = time() . Yii::$app->security->generateRandomString(10) . '.' . $file->extension;
        if ($file->saveAs($path . '/' . $name)) {
            return [
                'fileName' => $name,
                'uploaded' => 1,
                'url' => Yii::$app->params['frontendHostInfo'] . '/uploads/art/content/' . $name,
            ];
        }

        return ['error' => 'Ошибка сохранения файла'];
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionAutoComplete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return ['result' => 'error'];
        }

        $value = trim(Yii::$app->request->get('value'));
        $articles = Article::find()
            ->select(['title'])
            ->where(['like', 'title', $value])
            ->column();

        return $articles;
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
