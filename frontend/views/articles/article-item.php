<?php
/* @var $article \core\entities\Article\Article */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<li>
    <div class="article_prev_photo">
        <span><img src="<?= $article->getImageUrl() ?>" width="231" height="148" alt=""/></span>
    </div>
    <div class="article_prev_text">
        <a href="<?= $article->getUrl() ?>"><?= Html::encode($article->title) ?></a>
        <?= HtmlPurifier::process($article->prev_text) ?>
    </div>
</li>
