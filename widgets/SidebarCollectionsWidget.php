<?php

namespace widgets;


use core\repositories\CollectionRepository;
use yii\base\Widget;

class SidebarCollectionsWidget extends Widget
{
    public function run()
    {
        /* @var $repository CollectionRepository */
        $repository = \Yii::$container->get(CollectionRepository::class);
        $collections = $repository->getBySort();

        return $this->render('sidebar-collections-block', ['collections' => $collections]);
    }
}