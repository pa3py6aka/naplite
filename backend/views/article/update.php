<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ArticleManageForm */
/* @var $article \core\entities\Article\Article */

$this->title = 'Редактирование статьи #' . $article->id;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $article->id, 'url' => ['view', 'id' => $article->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
