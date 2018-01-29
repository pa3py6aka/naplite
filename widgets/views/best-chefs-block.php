<?php

/* @var $users \core\entities\User\User[] */

?>
<div class="rightbox">
    <h4>Лучшие кулинары</h4>
    <ul class="coolinars_top">
        <?php foreach ($users as $user): ?>
            <li>
                <a href="<?= $user->pageUrl ?>" class="userpick">
                    <span class="userpick_photo"><img src="<?= $user->avatarUrl ?>" alt="<?= $user->fullName ?>"/></span>
                    <span class="userpick_name">
                        <span class="cb"><?= $user->fullName ?></span>
                        <span class="stat_ico">
                            <span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
                            <span class="stat_ico_right"><?= $user->rate ?></span>
                            <span class="stat_rasp"></span>
                        </span>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="p20"></div>
    <div class="cb tac"><a href="javascript:void(0)" class="b_white"><i class="fa fa-arrow-right"></i>Все кулинары</a></div>
</div>
