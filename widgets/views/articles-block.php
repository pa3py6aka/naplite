<?php
/* @var $this \yii\web\View */
/* @var $articles \core\entities\Article\Article[]|array */

use yii\helpers\Url;

?>
<div class="textbox">
    <h2>Интересное о еде</h2>
    <ul class="article_prev">
        <?php foreach ($articles as $article): ?>
            <?= $this->render('@frontend/views/articles/article-item', ['article' => $article]) ?>
        <?php endforeach; ?>
    </ul>
    <div class="p40"></div>
    <div class="tac"><a href="<?= Url::to(['/articles/index']) ?>" class="b_white"><i class="fa fa-refresh"></i>Прочитать больше статей</a></div>
</div>
