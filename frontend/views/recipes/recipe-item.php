<?php
/* @var $recipe \core\entities\Recipe\Recipe */

use core\helpers\RecipeHelper;
use yii\helpers\Html;

?>
<li class="recipe_prev">
    <span class="recipe_prev_inner">
        <a href="<?= $recipe->url ?>" class="recipe_prev_top">
            <span class="recipe_prev_image"><img src="<?= $recipe->getMainPhoto(true) ?>" alt=""/></span>
            <span class="recipe_prev_th"><b><?= Html::encode($recipe->name) ?></b></span>
        </a>
        <?php /* ToDO: Отображение пользователя добавившего рецепт
        <span class="recipe_prev_user">
            <a href="<?= $recipe->author->pageUrl ?>" class="userpick">
                <span class="userpick_photo"><img src="<?= $recipe->author->avatarUrl ?>" alt=""/></span>
                <span class="userpick_name"><?= $recipe->author->fullName ?></span>
                <span class="userpick_date"><?= Yii::$app->formatter->asRelativeTime($recipe->created_at) ?></span>
            </a>
        </span>
        */ ?>
        <span class="recipe_prev_stat">
            <span class="recipe_prev_stat_left">
                <a href="#" class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
                    <span class="stat_ico_right"><?= $recipe->rate ?></span>
                    <span class="stat_rasp"></span>
                </a>
                <a href="#" class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
                    <span class="stat_ico_right"><?= $recipe->favorites_count ?></span>
                    <span class="stat_rasp"></span>
                </a>
                <a href="#" class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
                    <span class="stat_ico_right"><?= $recipe->comments_count ?></span>
                </a>
            </span>
            <span class="recipe_prev_stat_right">
                <span class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
                    <span class="stat_ico_right"><?= RecipeHelper::hoursFromMinutes($recipe->cooking_time) ?></span>
                </span>
            </span>
        </span>
    </span>
</li>
