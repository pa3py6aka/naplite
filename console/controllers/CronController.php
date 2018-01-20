<?php

namespace console\controllers;


use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

class CronController extends Controller
{
    public function actionCleaner()
    {
        $files = FileHelper::findFiles(Yii::getAlias("@tmp"));
        foreach ($files as $file) {
            if (filectime($file) < (time() - 86400)) {
                unlink($file);
            }
        }
    }
}