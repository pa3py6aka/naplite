<?php

namespace backend\controllers;


use backend\forms\ArticleSearch;
use core\entities\Article\ArticleTop;
use Yii;
use yii\web\Controller;

class ArticleTopController extends Controller
{
    public function actionIndex()
    {
        $topArticles = ArticleTop::find()->orderBy(['sort' => SORT_ASC])->all();
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'topArticles' => $topArticles,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppend($id)
    {
        if (ArticleTop::find()->where(['article_id' => $id])->exists()) {
            Yii::$app->session->setFlash('error', 'Эта статья уже присутствует в блоке топа');
        } else {
            $top = new ArticleTop([
                'article_id' => $id,
                'sort' => ArticleTop::find()->max('sort') + 1,
            ]);
            if ($top->save()) {
                Yii::$app->session->setFlash('success', 'Статья добавлена');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка добавления');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemove($id)
    {
        if ($articleTop = ArticleTop::findOne($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Статья удалена с топа');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка удаления');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMove($id, $d)
    {
        if ($articleTop = ArticleTop::findOne($id)) {
            $sign = $d == 'up' ? '<' : '>';
            if ($toChangeArticle = ArticleTop::find()->where([$sign, 'sort', $articleTop->sort])->limit(1)->one()) {
                $newSort = $toChangeArticle->sort;
                $toChangeArticle->sort = $articleTop->sort;
                $articleTop->sort = $newSort;
                if (!$toChangeArticle->save(false) || !$articleTop->save(false)) {
                    Yii::$app->session->setFlash('error', 'Ошибка взаимоействия с базой данных');
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}