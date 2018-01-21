<?php

/* @var $this yii\web\View */

use core\helpers\RecipeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $recipes \core\entities\Recipe[]|array */

$this->title = 'На плите! Кулинарные рецепты на любой вкус';
?>
<div class="content_left">
    <ul class="adaptive_categories">
        <li><a href="#"><span><b>Новогодние блюда</b></span><img src="/img/banner-ny.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Закуски</b></span><img src="/img/banner_snacks.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Мясные блюда</b></span><img src="/img/banner-meat.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Рыба и морепродукты</b></span><img src="/img/banner-fish.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Салаты</b></span><img src="/img/banner_salads.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Супы</b></span><img src="/img/banner_soups.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Вторые блюда</b></span><img src="/img/banner_seconds.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Выпечка</b></span><img src="/img/banner-cakes.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Десерты</b></span><img src="/img/banner-dessert.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Соусы</b></span><img src="/img/banner_sauces.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Напитки</b></span><img src="/img/banner-drinks.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Соления и заготовки</b></span><img src="/img/banner-pickles.jpg" width="240" height="170" alt=""/></a></li>
    </ul>
    <div class="cb"></div>
    <ul class="catalogue_ul">
        <li class="top_articles">
            <ul>
                <li class="top_articles_box">
                    <a href="#" class="top_articles_box_cover"></a>
                    <span class="top_articles_box_th">Секреты работы с кальмарами: выбираем, чистим, готовим</span>
                    <span class="top_articles_box_arrows">
								<a href="#" class="top_articles_box_arrows_left"><i class="fa fa-arrow-circle-left"></i><span></span></a>
								<span class="top_articles_box_arrows_center">5/1</span>
								<a href="#" class="top_articles_box_arrows_right"><i class="fa fa-arrow-circle-right"></i><span></span></a>
						  </span>
                    <span class="top_articles_box_grad"></span>
                    <span class="top_articles_box_image">
								<img src="/img/recipe_image_big.jpg" alt=""/>
							</span>
                </li>
            </ul>
        </li>
    </ul>
    <div class="cb"></div>
    <div class="th_2col">
        <div class="th_2col_left"><h2>Новые рецепты</h2></div>
        <div class="th_2col_right th_2col_links">
            <a href="#" class="icobox">
                <span class="icobox_left"><i class="fa fa-folder-open"></i></span>
                <span class="icobox_right">Рубрикатор рецептов</span>
            </a>
            <a href="#" class="icobox">
                <span class="icobox_left"><i class="fa fa-cubes"></i></span>
                <span class="icobox_right">Подобрать рецепт</span>
            </a>
            <a href="#" class="icobox">
                <span class="icobox_left"><i class="fa fa-search"></i></span>
                <span class="icobox_right">Поиск<span class="hidden1260"> рецептов</span></span>
            </a>
        </div>
    </div>
    <ul class="catalogue_ul">
        <?php foreach ($recipes as $recipe): ?>
            <li class="recipe_prev">
                <span class="recipe_prev_inner">
                    <a href="<?= Url::to(['/recipes/view', 'id' => $recipe->id]) ?>" class="recipe_prev_top">
                        <span class="recipe_prev_image"><img src="<?= $recipe->getMainPhoto(true) ?>" alt=""/></span>
                        <span class="recipe_prev_th"><b><?= Html::encode($recipe->name) ?></b></span>
                    </a>
                    <span class="recipe_prev_user">
                        <a href="<?= Url::to(['/users/view', 'id' => $recipe->author_id]) ?>" class="userpick">
                            <span class="userpick_photo"><img src="<?= $recipe->author->avatarUrl ?>" alt=""/></span>
                            <span class="userpick_name"><?= Html::encode($recipe->author->fullName) ?></span>
                            <span class="userpick_date"><?= Yii::$app->formatter->asRelativeTime($recipe->created_at) ?></span>
                        </a>
                    </span>
                    <span class="recipe_prev_stat">
                        <span class="recipe_prev_stat_left">
                            <a href="#" class="stat_ico">
                                <span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
                                <span class="stat_ico_right"><?= $recipe->rate ?></span>
                                <span class="stat_rasp"></span>
                            </a>
                            <a href="#" class="stat_ico">
                                <span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
                                <span class="stat_ico_right">0</span>
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
        <?php endforeach; ?>
        <!--<li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>
        <li class="recipe_prev">
					<span class="recipe_prev_inner">
						<a href="#" class="recipe_prev_top">
							<span class="recipe_prev_image"><img src="img/recipe_image_small.jpg" alt=""/></span>
							<span class="recipe_prev_th"><b>Морковно-яблочные котлеты</b></span>
						</a>
						<span class="recipe_prev_user">
							<a href="#" class="userpick">
								<span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
								<span class="userpick_name">Татьяна Левтерова</span>
								<span class="userpick_date">Сегодня в 15:00</span>
							</a>
						</span>
						<span class="recipe_prev_stat">
							<span class="recipe_prev_stat_left">
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-star-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-heart-o"></i></span>
									<span class="stat_ico_right">5</span>
									<span class="stat_rasp"></span>
								</a>
								<a href="#" class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
									<span class="stat_ico_right">5</span>
								</a>
							</span>
							<span class="recipe_prev_stat_right">
								<span class="stat_ico">
									<span class="stat_ico_left"><i class="fa fa-clock-o"></i></span>
									<span class="stat_ico_right">30 мин</span>
								</span>
							</span>
						</span>
					</span>
        </li>-->
    </ul>
    <div class="cb tac">
        <a href="#" class="b_brown b_shadow"><i class="fa fa-refresh"></i>Показать больше рецептов</a>
    </div>
    <div class="p40"></div>
    <div class="textbox">
        <h2>Интересное о еде</h2>
        <ul class="article_prev">
            <li>
                <div class="article_prev_photo">
                    <span><img src="img/article_prev.jpg" width="231" height="148" alt=""/></span>
                </div>
                <div class="article_prev_text">
                    <a href="#">5 лучших напитков с имбирем для иммунитета</a>
                    Первое, о чем мы вспоминаем, когда внезапно из жаркого лета окунаемся в прохладную, дождливую и сопливую осень – имбирь. Удивительно, но эта экзотическая пряность из южных стран оказалась востребована именно как лучшее подспорье в борьбе с сезонными простудами и гриппом. И неудивительно: имбирь по праву считается одним из лучших народных средств для профилактики простудных заболеваний, а также помогает восстановить иммунитет, если вирус все же достиг своей цели.
                </div>
            </li>
            <li>
                <div class="article_prev_photo">
                    <span><img src="img/article_prev.jpg" width="231" height="148" alt=""/></span>
                </div>
                <div class="article_prev_text">
                    <a href="#">5 лучших напитков с имбирем для иммунитета</a>
                    Первое, о чем мы вспоминаем, когда внезапно из жаркого лета окунаемся в прохладную, дождливую и сопливую осень – имбирь. Удивительно, но эта экзотическая пряность из южных стран оказалась востребована именно как лучшее подспорье в борьбе с сезонными простудами и гриппом. И неудивительно: имбирь по праву считается одним из лучших народных средств для профилактики простудных заболеваний, а также помогает восстановить иммунитет, если вирус все же достиг своей цели.
                </div>
            </li>
            <li>
                <div class="article_prev_photo">
                    <span><img src="img/article_prev.jpg" width="231" height="148" alt=""/></span>
                </div>
                <div class="article_prev_text">
                    <a href="#">5 лучших напитков с имбирем для иммунитета</a>
                    Первое, о чем мы вспоминаем, когда внезапно из жаркого лета окунаемся в прохладную, дождливую и сопливую осень – имбирь. Удивительно, но эта экзотическая пряность из южных стран оказалась востребована именно как лучшее подспорье в борьбе с сезонными простудами и гриппом. И неудивительно: имбирь по праву считается одним из лучших народных средств для профилактики простудных заболеваний, а также помогает восстановить иммунитет, если вирус все же достиг своей цели.
                </div>
            </li>
        </ul>
        <div class="p40"></div>
        <div class="tac"><a href="#" class="b_white"><i class="fa fa-refresh"></i>Прочитать больше статей</a></div>
    </div>
    <div class="textbox">
        <h2>Кулинарный форум</h2>
        <div class="blog_main">
            <div class="blog_prev">
                <a href="#" class="blog_prev_th">Девчонки! А как на пиццу замесить тесто? Девчонки! А как на пиццу замесить тесто?</a>
                <div class="blog_prev_stat">
                    <div class="blog_prev_stat_left">
                        <a href="#" class="userpick">
                            <span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
                            <span class="userpick_name">Татьяна Левтерова</span>
                            <span class="userpick_date">Сегодня в 15:00</span>
                        </a>
                    </div>
                    <div class="blog_prev_stat_right">
									<span class="recipe_prev_stat_left">
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
											<span class="stat_ico_right">5</span>
										</a>
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-eye"></i></span>
											<span class="stat_ico_right">57</span>
										</a>
									</span>
                    </div>
                </div>
            </div>
            <div class="blog_prev">
                <a href="#" class="blog_prev_th">Девчонки! А как на пиццу замесить тесто? Девчонки! А как на пиццу замесить тесто?</a>
                <div class="blog_prev_stat">
                    <div class="blog_prev_stat_left">
                        <a href="#" class="userpick">
                            <span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
                            <span class="userpick_name">Татьяна Левтерова</span>
                            <span class="userpick_date">Сегодня в 15:00</span>
                        </a>
                    </div>
                    <div class="blog_prev_stat_right">
									<span class="recipe_prev_stat_left">
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
											<span class="stat_ico_right">5</span>
										</a>
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-eye"></i></span>
											<span class="stat_ico_right">57</span>
										</a>
									</span>
                    </div>
                </div>
            </div>
            <div class="blog_prev">
                <a href="#" class="blog_prev_th">Девчонки! А как на пиццу замесить тесто? Девчонки! А как на пиццу замесить тесто?</a>
                <div class="blog_prev_stat">
                    <div class="blog_prev_stat_left">
                        <a href="#" class="userpick">
                            <span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
                            <span class="userpick_name">Татьяна Левтерова</span>
                            <span class="userpick_date">Сегодня в 15:00</span>
                        </a>
                    </div>
                    <div class="blog_prev_stat_right">
									<span class="recipe_prev_stat_left">
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
											<span class="stat_ico_right">5</span>
										</a>
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-eye"></i></span>
											<span class="stat_ico_right">57</span>
										</a>
									</span>
                    </div>
                </div>
            </div>
            <div class="blog_prev">
                <a href="#" class="blog_prev_th">Девчонки! А как на пиццу замесить тесто? Девчонки! А как на пиццу замесить тесто?</a>
                <div class="blog_prev_stat">
                    <div class="blog_prev_stat_left">
                        <a href="#" class="userpick">
                            <span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
                            <span class="userpick_name">Татьяна Левтерова</span>
                            <span class="userpick_date">Сегодня в 15:00</span>
                        </a>
                    </div>
                    <div class="blog_prev_stat_right">
									<span class="recipe_prev_stat_left">
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
											<span class="stat_ico_right">5</span>
										</a>
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-eye"></i></span>
											<span class="stat_ico_right">57</span>
										</a>
									</span>
                    </div>
                </div>
            </div>
            <div class="blog_prev">
                <a href="#" class="blog_prev_th">Девчонки! А как на пиццу замесить тесто? Девчонки! А как на пиццу замесить тесто?</a>
                <div class="blog_prev_stat">
                    <div class="blog_prev_stat_left">
                        <a href="#" class="userpick">
                            <span class="userpick_photo"><img src="img/photo.jpg" alt=""/></span>
                            <span class="userpick_name">Татьяна Левтерова</span>
                            <span class="userpick_date">Сегодня в 15:00</span>
                        </a>
                    </div>
                    <div class="blog_prev_stat_right">
									<span class="recipe_prev_stat_left">
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
											<span class="stat_ico_right">5</span>
										</a>
										<a href="#" class="stat_ico">
											<span class="stat_ico_left"><i class="fa fa-eye"></i></span>
											<span class="stat_ico_right">57</span>
										</a>
									</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="p40"></div>
        <div class="tac"><a href="#" class="b_white"><i class="fa fa-comment"></i>Перейти в форум</a></div>
    </div>
    <div class="textbox">
        <h2>Кулинарные ингредиенты</h2>
        <ul class="ingredients">
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
        </ul>
        <div class="tac"><a href="#" class="b_white"><i class="fa fa-refresh"></i>Узнать больше о рецептах</a></div>
    </div>
</div>
<div class="content_right">
    <a href="#" class="right_banner hidden740"><img src="img/banner-naplite.jpg" width="240" height="400" alt=""/></a>
    <div class="p40 hidden740"></div>
    <div class="socials_plugin">
        <div class="socials_tabs">
            <a href="#" class="socials_tabs_active">Вконтакте</a>
            <a href="#">Instagramm</a>
            <a href="#">Facebook</a>
        </div>
        <div class="socials_content"><img src="img/socials_plagin.jpg" width="240" height="278" alt=""/></div>
    </div>
    <div class="p40"></div>
    <a href="#" class="right_banner hidden740"><img src="img/banner-naplite.jpg" width="240" height="400" alt=""/></a>
    <div class="p40"></div>
    <div class="rightbox">
        <h4>Рецепты по теме</h4>
        <ul class="ul_open">
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>Для детей</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На завтрак</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На обед</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На полдник</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На праздник</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На природу</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>На ужин</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>Неожиданные гости</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>Рецепты для хлебопечки</span></a></li>
            <li><a href="#"><i class="fa fa-plus-square-o"></i><span>Специальное питание</span></a></li>
        </ul>
    </div>
</div>

<?php if (Yii::$app->request->get('signup') == 'ok') {
    echo $this->render('@frontend/views/auth/signup-ok-modal');
    $this->registerJs('$("#signupOkModal").show();');
} else if (Yii::$app->session->hasFlash("confirm-success")) {
    Yii::$app->session->removeFlash("confirm-success");
    echo $this->render('@frontend/views/auth/confirm-ok-modal');
    $this->registerJs('$("#confirmOkModal").show();');
} ?>
