<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\CollectionForm */
/* @var $collection \core\entities\Recipe\Collection\Collection */

$this->title = 'Редактирование подборки: ' . $collection->title;
$this->params['breadcrumbs'][] = ['label' => 'Подборки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $collection->title, 'url' => ['view', 'id' => $collection->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="collection-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
