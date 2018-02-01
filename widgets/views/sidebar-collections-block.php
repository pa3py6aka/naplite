<?php
/* @var $collections \core\entities\Recipe\Collection\Collection[] */

?>
<div class="right_banners">
    <?php foreach ($collections as $collection): ?>
        <a href="<?= $collection->getUrl() ?>">
            <span><b><?= $collection->title ?></b></span>
            <img src="<?= $collection->getImageUrl() ?>" width="240" height="170" alt="<?= $collection->title ?>"/>
        </a>
    <?php endforeach; ?>
</div>
