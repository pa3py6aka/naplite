<?php

use core\access\Rbac;
use core\helpers\ContentHelper;
use core\helpers\IngredientHelper;
use core\helpers\Pluralize;
use core\helpers\RecipeHelper;
use frontend\assets\RecipeViewAsset;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\RateWidget;
use widgets\SocialBlockWidget;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $recipe \core\entities\Recipe\Recipe */

$this->title = Html::encode($recipe->name) . ' | Версия для печати';

?>
<div class="textbox recipe-print">
    <div class="hrecipe">
        <h1 class="fn"><?= Html::encode($recipe->name) ?></h1>
        <div class="recipe_photo">
            <div class="recipe_photo"><img src="<?= $recipe->mainPhoto ?>" width="860" height="560" alt=""/></div>
        </div>
        <div class="recipe_content">
            <div class="recipe_content_left">
                <div class="recipe_content_left_text">
                    <?= ContentHelper::output($recipe->introductory_text) ?>
                </div>
                <div class="recipe_ing">
                    <div class="recipe_ing_th">
                        <h2>
                            Ингредиенты на <?= $recipe->persons ?> <?= Pluralize::get($recipe->persons, 'порцию', 'порции', 'порций', true) ?>
                        </h2>
                    </div>
                    <ul>
                        <?php foreach ($recipe->ingredientSections as $section): ?>
                            <li class="ingredients_th"><?= Html::encode($section->name) ?></li>
                            <?php foreach ($section->ingredients as $ingredient): ?>
                                <li class="ingredient">
                                    <span class="name"><?= Html::encode($ingredient->name) ?></span>
                                    <span class="ing_right">
                                        <span class="value"><?= Html::encode($ingredient->quantity) ?></span>
                                        <span class="type"><?= Html::encode($ingredient->uom) ?></span>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="recipe_content_right">
                <ul class="recipe_stat">
                    <li>
                        <span class="recipe_stat_top">Время готовки:</span>
                        <span class="recipe_stat_bottom">
                            <span class="recipe_stat_bottom_left"><i class="fa fa-clock-o"></i></span>
                            <span class="recipe_stat_bottom_right"><?= RecipeHelper::hoursFromMinutes($recipe->cooking_time) ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="recipe_stat_top">Порций:</span>
                        <span class="recipe_stat_bottom">
                            <span class="recipe_stat_bottom_left"><i class="fa fa-male"></i></span>
                            <span class="recipe_stat_bottom_right"><?= $recipe->persons ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="recipe_stat_top">Сложность:</span>
                        <span class="recipe_stat_bottom">
                            <span class="recipe_stat_bottom_left"><i class="fa fa-graduation-cap"></i></span>
                            <span class="recipe_stat_bottom_right"><?= $recipe->complexityName ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="recipe_stat_top">Кухня:</span>
                        <span class="recipe_stat_bottom">
                            <span class="recipe_stat_bottom_right"><?= $recipe->kitchen->name ?></span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="recipe_steps">
            <div class="recipe_steps_left">
                <h2>Рецепт приготовления</h2>
                <ul class="instructions">
                    <?php $n = 1; ?>
                    <?php foreach ($recipe->recipeSteps as $step): ?>
                        <li class="instruction">
                            <?php if ($step->photo): ?>
                                <span class="relative">
                                    <img src="<?= $step->photoUrl ?>" width="540" height="325" alt=""/>
                                    <span class="instruction_number"><?= $n ?></span>
                                </span>
                            <?php endif; ?>
                            <?= ContentHelper::output($step->description) ?>
                        </li>
                        <?php $n++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="recipe_steps_right"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        window.print();
    }
</script>