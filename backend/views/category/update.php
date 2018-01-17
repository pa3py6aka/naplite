<?php

/* @var $this yii\web\View */
/* @var $category core\entities\Category */
/* @var $model core\forms\manage\CategoryForm */

$this->title = 'Редактирование категории: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>