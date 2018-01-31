<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\CollectionForm */

$this->title = 'Новая подборка';
$this->params['breadcrumbs'][] = ['label' => 'Подборки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>