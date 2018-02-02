<?php

/* @var $this yii\web\View */
/* @var $model core\entities\Blog\Blog */

$this->title = 'Новый пост';
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
