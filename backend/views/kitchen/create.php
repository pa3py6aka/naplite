<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Kitchen */

$this->title = 'Новая кухня мира';
$this->params['breadcrumbs'][] = ['label' => 'Кухни мира', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kitchen-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
