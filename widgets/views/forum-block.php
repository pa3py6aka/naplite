<?php
/* @var $blogs \core\entities\Blog\Blog[] */

use yii\helpers\Url;

?>
<div class="textbox">
    <h2>Кулинарный форум</h2>
    <div class="blog_main">
        <?php foreach ($blogs as $blog): ?>
            <?= $this->render('@frontend/views/blog/blog-item', ['blog' => $blog]) ?>
        <?php endforeach; ?>
    </div>
    <div class="p40"></div>
    <div class="tac"><a href="<?= Url::to(['/blog/index']) ?>" class="b_white"><i class="fa fa-comment"></i>Перейти в форум</a></div>
</div>
