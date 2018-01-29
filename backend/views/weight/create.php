<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Weight */

$this->title = 'Новый продукт';
$this->params['breadcrumbs'][] = ['label' => 'Таблица мер и весов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weight-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
