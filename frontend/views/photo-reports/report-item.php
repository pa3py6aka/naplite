<?php
/* @var $report \core\entities\Recipe\PhotoReport */

?>
<li>
    <?php /*<a href="<?= $report->getImageUrl(false) ?>"  data-lightbox="image-<?= $report->id ?>">*/ ?>
    <div href="javascript:void(0);">
        <span class="photoreport_stat">
            <span class="userpick_photo"><img src="<?= $report->user->avatarUrl ?>" alt="<?= $report->user->fullName ?>"/></span>
            <span class="userpick_name"><?= $report->user->fullName ?></span>
        </span>
        <a href="<?= $report->getImageUrl(false) ?>" class="photo-report-image">
            <img src="<?= $report->imageUrl ?>" width="300" height="200" alt=""/>
        </a>
    </div>
</li>
