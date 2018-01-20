<?php
/* @var $currentRate int */
/* @var $userRate int */
/* @var $recipeId int */

?>
<span class="stars_box" data-recipe-id="<?= $recipeId ?>">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <a href="javascript:void(0)" data-value="<?= $i ?>" class="<?= Yii::$app->user->isGuest ? 'loginButton' : 'rateLink' ?><?= $userRate >= $i ? ' active' : '' ?>"><i class="fa fa-star-o"></i></a>
    <?php endfor; ?>
</span>
<span data-rate-total="<?= $currentRate ?>"><?= $currentRate ?></span>
