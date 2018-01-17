<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Kitchen */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Кухни мира', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="kitchen-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
