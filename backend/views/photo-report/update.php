<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Recipe\PhotoReport */

$this->title = 'Update Photo Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Photo Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="photo-report-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
