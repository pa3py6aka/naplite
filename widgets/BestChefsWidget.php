<?php

namespace widgets;


use core\entities\User\User;
use yii\base\Widget;

class BestChefsWidget extends Widget
{
    public function run()
    {
        $users = User::find()->active()->orderBy(['rate' => SORT_DESC])->limit(5)->all();
        return $this->render('best-chefs-block', ['users' => $users]);
    }
}