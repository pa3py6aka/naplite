<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Uom */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Единицы измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="uom-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
