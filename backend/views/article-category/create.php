<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ArticleCategoryForm */

$this->title = 'Новая категория';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>