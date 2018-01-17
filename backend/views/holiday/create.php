<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Holiday */

$this->title = 'Новый праздник';
$this->params['breadcrumbs'][] = ['label' => 'Праздники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
