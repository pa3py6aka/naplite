<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Weight */

$this->title = 'Редактирование продукта: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Таблица мер и весов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="weight-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
