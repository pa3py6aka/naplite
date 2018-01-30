<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\entities\Recipe\PhotoReport;
use core\forms\PhotoReportCreateForm;
use core\services\TransactionManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PhotoReportsController extends Controller
{
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

    public function actionCreate()
    {
        $form = new PhotoReportCreateForm();
        if ($form->load(Yii::$app->request->post())) {
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
                        Yii::$app->session->setFlash('success', [['Фотоотчёт', 'Фотография успешно добавлена<br />в фотоотчёт по рецепту']]);
                    });
                } catch (\Error $e) {
                    Yii::error($e->getMessage());
                    Yii::$app->session->setFlash('error', [['Ошибка', 'При загрузке файла возникла непредвиденная ошибка<br />Мы уже работаем над этим.']]);
                }
            }
        }
        return $this->redirect(['/recipes/view', 'id' => $form->recipeId]);
    }
}