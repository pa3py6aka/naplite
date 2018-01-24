<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Blog\BlogCategory */

$this->title = 'Новая категория блога';
$this->params['breadcrumbs'][] = ['label' => 'Категории блога', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
