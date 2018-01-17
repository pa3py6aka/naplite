<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Holiday */

$this->title = 'Редактирование праздника: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Праздники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="holiday-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
