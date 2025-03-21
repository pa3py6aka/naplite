<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\entities\Recipe\PhotoReport;
use core\forms\PhotoReportCreateForm;
use core\repositories\PhotoReportsRepository;
use core\repositories\RecipeRepository;
use core\services\TransactionManager;
use Yii;
use yii\base\Module;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PhotoReportsController extends Controller
{
    private $repository;

    public function __construct($id, Module $module, PhotoReportsRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = $this->repository->getPhotos();

        return $this->render('index', ['provider' => $provider]);
    }

    public function actionCreate()
    {
        $form = new PhotoReportCreateForm();
        if ($form->load(Yii::$app->request->post())) {
            $recipe = (new RecipeRepository())->get($form->recipeId);
            if (!$form->validate()) {
                Yii::$app->session->setFlash('error', [['Ошибка', $form->getFirstError('file')]]);
            } else {
                try {
                    (new TransactionManager())->wrap(function() use ($form) {
                        $report = PhotoReport::create($form->recipeId, Yii::$app->user->id);
                        if (!$report->save()) {
                            throw new \RuntimeException("Ошибка записи в базу");
                        }
                        $fileName = $report->id . '_' . time() . '.' . $form->file->extension;
                        $path = Yii::getAlias('@uploads/reports/');
                        if (!$form->file->saveAs($path . $fileName)) {
                            throw new \ErrorException("Ошибка сохранения файла");
                        }
                        Yii::$app->photoSaver->create300x200($path . $fileName);
                        Yii::$app->photoSaver->addWatermark($path . $fileName);
                        $report->file = $fileName;
                        if (!$report->save()) {
                            throw new \RuntimeException("Ошибка записи в базу");
                        }
                        Yii::$app->session->setFlash('success', [['Фотоотчёт', Yii::$app->settings->get('photoReportAddedMessage')]]);
                    });
                } catch (\Error $e) {
                    Yii::error($e->getMessage());
                    Yii::$app->session->setFlash('error', [['Ошибка', 'При загрузке файла возникла непредвиденная ошибка<br />Мы уже работаем над этим.']]);
                }
            }
        } else {
            throw new UserException("Ошибка при загрузке формы, попробуйте позже");
        }
        return $this->redirect($recipe->getUrl());
    }
}