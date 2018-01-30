<?php

use core\helpers\ContentHelper;
use yii\helpers\Html;

/* @var $article \core\entities\Article\Article */

?>
<li>
    <div class="article_prev_photo">
        <span><img src="<?= $article->getImageUrl() ?>" width="231" height="148" alt=""/></span>
    </div>
    <div class="article_prev_text">
        <a href="<?= $article->getUrl() ?>"><?= Html::encode($article->title) ?></a>
        <?= ContentHelper::output($article->prev_text) ?>
    </div>
</li>
