<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Recipe\PhotoReport */

$this->title = 'Create Photo Report';
$this->params['breadcrumbs'][] = ['label' => 'Photo Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-report-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
