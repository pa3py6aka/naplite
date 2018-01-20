<?php

use core\access\Rbac;
use core\helpers\IngredientHelper;
use core\helpers\Pluralize;
use core\helpers\RecipeHelper;
use frontend\assets\RecipeViewAsset;
use widgets\RateWidget;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $recipe \core\entities\Recipe */
/* @var $commentModel \core\forms\CommentForm */

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
                        <a href="<?= Url::to(['/category/view', 'id' => $parent->slug]) ?>"><?= $parent->name ?></a>
                    <?php endif;
                }
                ?>
                <span><i class="fa fa-circle"></i></span>
                <a href="<?= Url::to(['/category/view', 'id' => $recipe->category->slug]) ?>"><?= $recipe->category->name ?></a>
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
                        <?= nl2br(Html::encode($recipe->introductory_text)) ?>
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
                                <span class="recipe_stat_bottom_right"><?= RecipeHelper::hoursFromMinutes($recipe->cooking_time) ?> часа</span>
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
                    <div class="recipe_stat_buttons">
                        <a href="#" class="b_gray"><i class="fa fa-plus"></i>Сохранить рецепт</a>
                        <a href="#" class="b_gray"><i class="fa fa-print"></i>Распечатать рецепт</a>
                        <a href="#" class="b_gray"><i class="fa fa-calendar"></i>Таблица мер и весов</a>
                        <a href="#" class="b_gray"><i class="fa fa-comment"></i>Обсудить с автором</a>
                    </div>
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
                                <?= nl2br(Html::encode($step->description)) ?>
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
                    <a href="javascript:void(0)" <?= Yii::$app->user->isGuest ? 'class="loginButton"' : 'data-link="goToComments"' ?>><span><b>Задайте вопрос:</b></span><span><i class="fa fa-comment-o"></i><?= $recipe->comments_count ?></span></a>
                </div>
                <div class="recipe_page_bottom_right">
                    <a href="javascript:void(0)"><span><b>Сохраните рецепт:</b></span><span><i class="fa fa-heart-o"></i>0</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="textbox" id="commentsBlock">
        <div class="th_2col th_button">
            <div class="th_2col_left"><h3>Обсуждение рецепта</h3></div>
            <div class="th_2col_right th_2col_links">
                <a href="javascript:void(0)" class="icobox">
                    <span class="icobox_left"><i class="fa fa-camera"></i></span>
                    <span class="icobox_right">Добавить фотоотчет</span>
                </a>
            </div>
        </div>

        <?= $this->render('comment-form', ['commentModel' => $commentModel, 'n' => 1]) ?>

        <?php if (count($recipe->recipeComments)): ?>
        <ul class="comments">
            <?php foreach ($recipe->recipeComments as $comment): ?>
            <li class="comment">
                <div class="comment_left">
                    <a href="<?= Url::to(['/users/view', 'id' => $comment->author_id]) ?>">
                        <img src="<?= $comment->author->avatarUrl ?>" alt=""/>
                    </a>
                </div>
                <div class="comment_right">
                    <div class="comment_name"><a href="javascript:void(0)"><b><?= $comment->author->fullName ?></b></a><span class="date">, <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?></span></div>
                    <div class="comment_text">
                        <?= nl2br(Html::encode($comment->content)) ?>
                    </div>
                </div>
                <div class="comment_reply"><a href="javascript:void(0)" class="<?= Yii::$app->user->can(Rbac::ROLE_USER) ? 'replyToComment' : 'loginButton' ?>"><i class="fa fa-comment-o"></i>Ответить</a></div>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="p40"></div>

        <?= $this->render('comment-form', ['commentModel' => $commentModel, 'n' => 2]) ?>

        <?php endif; ?>
    </div>
    <div class="textbox">
        <div class="th_2col th_button">
            <div class="th_2col_left"><h2>Фотоотчеты к рецепту</h2></div>
            <div class="th_2col_right th_2col_links">
                <a href="#" class="icobox">
                    <span class="icobox_left"><i class="fa fa-camera"></i></span>
                    <span class="icobox_right">Добавить фотоотчет</span>
                </a>
            </div>
        </div>
        <ul class="photoreport">
            <li>
                <a href="#">
							<span class="photoreport_stat">
								<span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
							</span>
                    <img src="/img/recipe_image_small.jpg" width="300" height="200" alt=""/>
                </a>
            </li>
            <li>
                <a href="#">
							<span class="photoreport_stat">
								<span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
							</span>
                    <img src="/img/recipe_image_small.jpg" width="300" height="200" alt=""/>
                </a>
            </li>
            <li>
                <a href="#">
							<span class="photoreport_stat">
								<span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
							</span>
                    <img src="/img/recipe_image_small.jpg" width="300" height="200" alt=""/>
                </a>
            </li>
            <li>
                <a href="#">
							<span class="photoreport_stat">
								<span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
							</span>
                    <img src="/img/recipe_image_small.jpg" width="300" height="200" alt=""/>
                </a>
            </li>
            <li>
                <a href="#">
							<span class="photoreport_stat">
								<span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
							</span>
                    <img src="/img/recipe_image_small.jpg" width="300" height="200" alt=""/>
                </a>
            </li>
        </ul>
        <div class="cb"></div>
        <div class="p40"></div>
        <div class="cb tac"><a href="#" class="b_white"><i class="fa fa-list"></i>Смотреть все фотоотчеты</a></div>
    </div>
</div>
<div class="content_right">
    <a href="#" class="right_banner"><img src="/img/banner-naplite.jpg" width="240" height="400" alt=""/></a>
    <div class="p40"></div>
    <div class="rightbox">
        <h4>Лучшие кулинары</h4>
        <ul class="coolinars_top">
            <li>
                <a href="#" class="userpick">
                    <span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
                    <span class="userpick_name">
								<span class="cb">Татьяна Левтерова</span>
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</span>
							</span>
                </a>
            </li>
            <li>
                <a href="#" class="userpick">
                    <span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
                    <span class="userpick_name">
								<span class="cb">Татьяна Левтерова</span>
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</span>
							</span>
                </a>
            </li>
            <li>
                <a href="#" class="userpick">
                    <span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
                    <span class="userpick_name">
								<span class="cb">Татьяна Левтерова</span>
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</span>
							</span>
                </a>
            </li>
            <li>
                <a href="#" class="userpick">
                    <span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
                    <span class="userpick_name">
								<span class="cb">Татьяна Левтерова</span>
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</span>
							</span>
                </a>
            </li>
            <li>
                <a href="#" class="userpick">
                    <span class="userpick_photo"><img src="/img/photo.jpg" alt=""/></span>
                    <span class="userpick_name">
								<span class="cb">Татьяна Левтерова</span>
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</span>
							</span>
                </a>
            </li>
        </ul>
        <div class="p20"></div>
        <div class="cb tac"><a href="#" class="b_white"><i class="fa fa-arrow-right"></i>Все кулинары</a></div>
    </div>
    <div class="p40"></div>
    <div class="socials_plugin">
        <div class="socials_tabs">
            <a href="#" class="socials_tabs_active">Вконтакте</a>
            <a href="#">Instagramm</a>
            <a href="#">Facebook</a>
        </div>
        <div class="socials_content"><img src="/img/socials_plagin.jpg" width="240" height="278" alt=""/></div>
    </div>
</div>
