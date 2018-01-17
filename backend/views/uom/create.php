<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Uom */

$this->title = 'Новая единица измерения';
$this->params['breadcrumbs'][] = ['label' => 'Единицы измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uom-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
