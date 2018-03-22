<?php

namespace console\controllers;


use core\components\PhotoSaver;
use core\entities\Kitchen;
use yii\console\Controller;

class HelperController extends Controller
{
    public function actionCreateKitchenThumbs()
    {
        $saver = new PhotoSaver();
        $kitchens = Kitchen::find()->all();
        foreach ($kitchens as $kitchen) {
            /* @var $kitchen Kitchen */
            if ($kitchen->image) {
                $saver->fitBySize($kitchen->getImagePath() . $kitchen->image, 570, 400, $kitchen->getImagePath() . $kitchen->getThumbName());
                echo $kitchen->name . ": превьюшка создана" . PHP_EOL;
            }
        }
    }
}