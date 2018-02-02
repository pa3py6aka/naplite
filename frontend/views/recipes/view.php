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
/* @var $commentModel \core\forms\CommentForm */
/* @var $photoReports \core\entities\Recipe\PhotoReport[] */
/* @var $isFavorite bool */

RecipeViewAsset::register($this);
$this->title = Html::encode($recipe->name);

?>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="/">Главная</a>
                <?php foreach ($recipe->category->parents as $parent) {
                    if (!$parent->isRoot()): ?>
                        <span><i class="fa fa-circle"></i></span>
                        <a href="<?= $parent->url ?>"><?= $parent->name ?></a>
                    <?php endif;
                }
                ?>
                <span><i class="fa fa-circle"></i></span>
                <a href="<?= $recipe->category->url ?>"><?= $recipe->category->name ?></a>
            </div>
        </div>
        <div class="hrecipe">
            <h1 class="fn"><?= Html::encode($recipe->name) ?></h1>
            <div class="recipe_photo">
                <?php if (count($recipe->recipePhotos) > 1): ?>
                    <?= Carousel::widget([
                        'items' => RecipeHelper::getPhotosForCarousel($recipe),
                        'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
                        'showIndicators' => false,
                        'controls' => [
                            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                        ]
                    ]); ?>
                <?php elseif ($recipe->mainPhoto): ?>
                    <div class="recipe_photo"><img src="<?= $recipe->mainPhoto ?>" width="860" height="560" alt=""/></div>
                <?php endif; ?>
            </div>
            <div class="recipe_content">
                <div class="recipe_content_left">
                    <div class="recipe_content_left_text">
                        <?= ContentHelper::output($recipe->introductory_text) ?>
                    </div>
                    <div class="recipe_ing">
                        <div class="recipe_ing_th">
                            <h2>
                                Ингредиенты на
                                <span><input type="text" value="<?= $recipe->persons ?>" id="personsCount" /></span>
                                <span id="portionsWord"><?= Pluralize::get($recipe->persons, 'порцию', 'порции', 'порций', true) ?></span>
                            </h2>
                        </div>
                        <ul>
                            <?php foreach ($recipe->ingredientSections as $section): ?>
                                <li class="ingredients_th"><?= Html::encode($section->name) ?></li>
                                <?php foreach ($section->ingredients as $ingredient): ?>
                                    <li class="ingredient">
                                        <span class="name"><?= Html::encode($ingredient->name) ?></span>
                                        <span class="ing_right">
											<span
                                                class="value"
                                                data-default="<?= IngredientHelper::defaultValue(Html::encode($ingredient->quantity), $recipe->persons) ?>"
                                            >
                                                <?= Html::encode($ingredient->quantity) ?>
                                            </span>
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
                        <?php if ($recipe->preparation_time): ?>
                            <li>
                                <span class="recipe_stat_top">Время подготовки:</span>
                                <span class="recipe_stat_bottom">
                                <span class="recipe_stat_bottom_left"><i class="fa fa-clock-o"></i></span>
                                <span class="recipe_stat_bottom_right"><?= RecipeHelper::hoursFromMinutes($recipe->preparation_time) ?></span>
                            </span>
                            </li>
                        <?php endif; ?>
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
                    <div class="recipe_stat_buttons">
                        <a href="javascript:void(0)" class="b_gray<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>"<?= !Yii::$app->user->isGuest ? ' data-link="save-recipe-link" data-recipe-id="' . $recipe->id . '"' : '' ?>>
                            <i class="fa fa-<?= $isFavorite ? 'minus' : 'plus' ?>"></i><?= $isFavorite ? 'Убрать из избранных' : 'Сохранить рецепт' ?>
                        </a>
                        <a href="<?= Url::to(['/recipes/print', 'id' => $recipe->id]) ?>" class="b_gray" target="_blank">
                            <i class="fa fa-print"></i>Распечатать рецепт
                        </a>
                        <a href="javascript:void(0)" data-link="weights-search-modal" class="b_gray">
                            <i class="fa fa-calendar"></i>Таблица мер и весов
                        </a>
                        <a href="javascript:void(0)" class="b_gray" data-link="goToComments"><i class="fa fa-comment"></i>Обсудить с автором</a>
                    </div>
                </div>
            </div>

            <?php if (Yii::$app->settings->get('bannerBeforeSteps_show')) {
                echo Yii::$app->settings->get('bannerBeforeSteps');
            } ?>

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
        <div class="recipe_page_bottom">
            <div class="recipe_page_bottom_inner">
                <div class="recipe_page_bottom_left">
                    <span><b>Оцените!</b></span>
                    <?= RateWidget::widget(['recipe' => $recipe]) ?>
                </div>
                <div class="recipe_page_bottom_center hidden1150-table-cell">
                    <a href="javascript:void(0)" <?= Yii::$app->user->isGuest ? 'class="loginButton"' : 'data-link="goToComments"' ?>>
                        <span><b>Задайте вопрос:</b></span>
                        <span><i class="fa fa-comment-o"></i><?= $recipe->comments_count ?></span>
                    </a>
                </div>
                <div class="recipe_page_bottom_right">
                    <a href="javascript:void(0)"<?= Yii::$app->user->isGuest ? ' class="loginButton"' : ' data-link="save-recipe-link" data-recipe-id="' . $recipe->id . '"' ?>>
                        <span><b>Сохраните рецепт:</b></span>
                        <span data-role="count"><i class="fa fa-heart-o"></i><?= $recipe->favorites_count ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="textbox" id="commentsBlock">
        <div class="th_2col th_button">
            <div class="th_2col_left"><h3>Обсуждение рецепта</h3></div>
            <div class="th_2col_right th_2col_links">
                <a href="javascript:void(0)" class="icobox<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>"<?= Yii::$app->user->isGuest ? '' : ' data-link="create-photo-report-link"' ?>>
                    <span class="icobox_left"><i class="fa fa-camera"></i></span>
                    <span class="icobox_right">Добавить фотоотчет</span>
                </a>
            </div>
        </div>

        <?= $this->render('@frontend/views/common/comments-block', [
            'commentModel' => $commentModel,
            'comments' => $recipe->recipeComments,
        ]) ?>
    </div>
    <div class="textbox">
        <div class="th_2col th_button">
            <div class="th_2col_left"><h2>Фотоотчеты к рецепту</h2></div>
            <div class="th_2col_right th_2col_links">
                <a href="javascript:void(0)" class="icobox<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>"<?= Yii::$app->user->isGuest ? '' : ' data-link="create-photo-report-link"' ?>>
                    <span class="icobox_left"><i class="fa fa-camera"></i></span>
                    <span class="icobox_right">Добавить фотоотчет</span>
                </a>
            </div>
        </div>
        <ul class="photoreport">
            <?php if (!count($photoReports)): ?>
                <div class="no-counts">
                    Фотоотчёты к рецепту пока отсутствуют
                </div>
            <?php else: ?>
                <?php foreach ($photoReports as $photoReport): ?>
                    <?= $this->render('@frontend/views/photo-reports/report-item', ['report' => $photoReport]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="cb"></div>
        <div class="p40"></div>
        <?php if (count($photoReports)): ?>
            <div class="cb tac">
                <a href="#" class="b_white"><i class="fa fa-list"></i>Смотреть все фотоотчеты</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="content_right">
    <?php //ToDo сделать вывод баннера актуального праздника на данный момент ?>
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
</div>

<?= $this->render('@frontend/views/photo-reports/new-report-modal', ['recipeId' => $recipe->id]) ?>