<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head lang="<?= Yii::$app->language ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="top">
    <div class="wrap">
        <div class="top_panel">
            <div class="top_panel_left">
                <ul>
                    <li><a href="#"><i class="fa fa-cutlery"></i>Рецепты</a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-info-circle"></i>Статьи</a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-globe"></i>Кухни<span class="hidden1260"> мира</span></a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-shopping-bag"></i>Ингредиенты</a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-female"></i>Диеты</a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-comments"></i><span class="hidden1260">Кулинарный</span> Форум</a></li>
                    <li class="space"></li>
                    <li><a href="#"><i class="fa fa-balance-scale"></i>Таблица мер<span class="hidden1260"> и весов</span></a></li>
                </ul>
            </div>
            <div class="top_panel_right">
                <ul class="not_logged">
                    <li><a href="#" class="b_red"><i class="fa fa-plus"></i>Добавить рецепт</a></li>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="loginButton"><a href="javascript:void(0)" class="b_green"><i class="fa fa-lock"></i>Войти</a></li>
                    <?php else: ?>
                        <li>
						<span class="top_userpick">
							<span class="top_userpick_inner">
								<span class="top_userpick_photo"><img src="img/photo.jpg" width="200" height="200" alt=""/></span>
								<span class="top_userpick_arrow"><i class="fa fa-sort-down"></i></span>
							</span>
							<ul>
								<li><a href="#"><i class="fa fa-user"></i>Личная страница</a></li>
								<li><a href="#"><i class="fa fa-book"></i>Кулинарная книга</a></li>
								<!--<li><a href="#"><i class="fa fa-envelope"></i>Сообщения</a></li>-->
								<li><a href="#"><i class="fa fa-cutlery"></i>Мои рецепты</a></li>
								<li><a href="#"><i class="fa fa-comment"></i>Мои посты</a></li>
								<li><a href="#"><i class="fa fa-photo"></i>Мои фотоотчеты</a></li>
								<li><a href="#"><i class="fa fa-gear"></i>Настройки</a></li>
								<li><a href="<?= Url::to(['/auth/logout']) ?>" data-method="post"><i class="fa fa-sign-out"></i>Выйти</a></li>
							</ul>
						</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="top_bottom">
            <div class="top_bottom_left"><a href="#"><img src="/img/logo.png" width="282" height="64" alt=""/></a></div>
            <div class="top_bottom_center">
                <form action="sdfgsdfg.php" method="post">
                    <div class="top_bottom_center_inner">
                        <div class="top_bottom_center_inner_left"><input type="text" placeholder="Поиск рецепта..." /></div>
                        <div class="top_bottom_center_inner_right"><a href="#"><i class="fa fa-search"></i><span class="hidden740">Найти</span><span class="hidden1260"> рецепт</span></a></div>
                    </div>
                </form>
            </div>
            <div class="top_bottom_right">
                Добавьте свой рецепт!
                <?php if (Yii::$app->user->isGuest): ?>
                    <br />регистрация займёт меньше 1 мин!
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="top_adaptive">
    <div class="top_adaptive_inner_top">
        <div class="top_adaptive_left"><a href="#"><img src="/img/logo.png" width="282" height="64" alt=""/></a></div>
        <div class="top_adaptive_right">
            <a href="#"><i class="fa fa-bars"></i></a>
            <span class="adaptive_top_menu">
				<ul>
					<li><a href="#">Рецепты</a></li>
					<li><a href="#">Статьи</a></li>
					<li><a href="#">Кухни мира</a></li>
					<li><a href="#">Ингредиенты</a></li>
					<li><a href="#">Диеты</a></li>
					<li><a href="#">Кулинарный Форум</a></li>
					<li><a href="#">Таблица мер и весов</a></li>
					<li class="adaptive_top_menu_space"></li>
					<li>
						<ul class="not_logged">
							<li><a href="#" class="b_red"><i class="fa fa-plus"></i>Добавить рецепт</a></li>
                            <?php if (Yii::$app->user->isGuest): ?>
							    <li class="loginButton"><a href="#" class="b_green"><i class="fa fa-lock"></i>Войти</a></li>
                            <?php else: ?>
                                <!-- login_user -->
                                <li>
                                    <span class="top_userpick">
                                        <span class="top_userpick_inner">
                                            <span class="top_userpick_photo"><img src="img/photo.jpg" width="200" height="200" alt=""/></span>
                                            <span class="top_userpick_arrow"><i class="fa fa-sort-down"></i></span>
                                        </span>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-user"></i>Личная страница</a></li>
                                            <li><a href="#"><i class="fa fa-book"></i>Кулинарная книга</a></li>
                                            <!--<li><a href="#"><i class="fa fa-envelope"></i>Сообщения</a></li>-->
                                            <li><a href="#"><i class="fa fa-cutlery"></i>Мои рецепты</a></li>
                                            <li><a href="#"><i class="fa fa-comment"></i>Мои посты</a></li>
                                            <li><a href="#"><i class="fa fa-photo"></i>Мои фотоотчеты</a></li>
                                            <li><a href="#"><i class="fa fa-gear"></i>Настройки</a></li>
                                            <li><a href="<?= Url::to(['/auth/logout']) ?>" data-method="post"><i class="fa fa-sign-out"></i>Выйти</a></li>
                                        </ul>
                                    </span>
                                </li>
                            <?php endif; ?>
						</ul>
					</li>
				</ul>
			</span>
        </div>
    </div>
    <div class="top_adaptive_bottom">
        <form action="sdfgsdfg.php" method="post">
            <div class="top_bottom_center_inner">
                <div class="top_bottom_center_inner_left"><input type="text" placeholder="Поиск рецепта..." /></div>
                <div class="top_bottom_center_inner_right"><a href="#"><i class="fa fa-search"></i><span class="hidden740">Найти</span><span class="hidden1260"> рецепт</span></a></div>
            </div>
        </form>
    </div>
</div>
<div class="top_menu_outer">
    <div class="top_menu">
        <a href="#" class="top_menu_adaptive"><i class="fa fa-bars"></i>&nbsp;Открыть список рецептов</a>
        <ul>
            <li class="top_menu_arrow_left hidden1260"></li>
            <li><a href="#">Закуски</a></li>
            <li><a href="#">Салаты</a></li>
            <li><a href="#">Супы</a></li>
            <li><a href="#">Вторые блюда</a></li>
            <li><a href="#">Выпечка</a></li>
            <li><a href="#">Десерты</a></li>
            <li><a href="#">Соусы</a></li>
            <li><a href="#">Напитки</a></li>
            <li><a href="#">Заготовки</a></li>
            <li class="hidden880"><a href="#">Разное</a></li>
            <li class="top_menu_arrow_right hidden1260"></li>
        </ul>
    </div>
</div>
<div class="wrap">
    <div class="content">
        <?= $content ?>
    </div>
</div>
<div class="footer">
    <div class="wrap">
        <div class="footer_top">
            <div class="footer_col">
                <b><a href="#">Закуски</a></b>
                <a href="#">Бутерброды</a>
                <a href="#">Горячие</a>
                <a href="#">Мясные</a>
                <a href="#">Из субпродуктов</a>
                <a href="#">Из рыбы</a>
                <a href="#">Из морепродуктов</a>
                <a href="#">Из овощей</a>
                <a href="#">Из фруктов</a>
                <a href="#">С грибами</a>
                <a href="#">Паштеты и террины</a>
                <a href="#">Закусочные торты</a>
                <a href="#">Закуски в лаваше</a>
                <a href="#">Из сыра и творога</a>
                <a href="#">Профитроли, тарталетки</a>
                <a href="#">Холодец и заливное</a>
                <a href="#">Закуски из яиц</a>
                <p></p>
                <b><a href="#">Напитки</a></b>
                <a href="#">Алкогольные</a>
                <a href="#">Безалкогольные</a>
                <a href="#">Горячие</a>
                <a href="#">Фруктовые</a>
                <a href="#">Овощные</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Салаты</a></b>
                <a href="#">Классические салаты</a>
                <a href="#">Тёплые салаты</a>
                <a href="#">Мясные салаты</a>
                <a href="#">Из птицы</a>
                <a href="#">С субпродуктами</a>
                <a href="#">Из рыбы и морепродуктов</a>
                <a href="#">Грибные</a>
                <a href="#">Овощные</a>
                <a href="#">С пастой (макаронами)</a>
                <a href="#">С фасолью</a>
                <a href="#">Фруктовые</a>
                <a href="#">Прочие салаты</a>
                <p></p>
                <b><a href="#">Соусы</a></b>
                <a href="#">Майонез</a>
                <a href="#">Острые</a>
                <a href="#">Сладкие</a>
                <a href="#">На основе яиц и молока</a>
                <a href="#">Томатные соусы</a>
                <a href="#">Соусы с уксусом</a>
                <a href="#">Дипы</a>
                <a href="#">Ореховые соусы</a>
                <a href="#">Соусы РУ</a>
                <a href="#">Соусы из ягод и фруктов</a>
                <a href="#">Грибные соусы</a>
                <a href="#">Соусы для пасты</a>
                <a href="#">Заправки</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Вторые блюда</a></b>
                <a href="#">Из мяса</a>
                <a href="#">Из птицы</a>
                <a href="#">Из фарша</a>
                <a href="#">Субпродукты</a>
                <a href="#">Рыба и морепродукты</a>
                <a href="#">Запеканки</a>
                <a href="#">Домашняя колбаса</a>
                <a href="#">В горшочках</a>
                <a href="#">Пельмени, вареники</a>
                <a href="#">Паста</a>
                <a href="#">Клецки, галушки</a>
                <a href="#">Овощи, грибы</a>
                <a href="#">Каши</a>
                <p></p>
                <b><a href="#">Супы</a></b>
                <a href="#">Борщи</a>
                <a href="#">Мясные супы</a>
                <a href="#">Рыбные супы</a>
                <a href="#">Сырные супы</a>
                <a href="#">Крем-супы</a>
                <a href="#">Супы из морепродуктов</a>
                <a href="#">Холодные супы</a>
                <a href="#">Рассольники</a>
                <a href="#">Грибные супы</a>
                <a href="#">Супы с фасолью</a>
            </div>
            <div class="footer_col">
                <b><a href="#">Заготовки</a></b>
                <a href="#">Из овощей</a>
                <a href="#">Из ягод, фруктов</a>
                <a href="#">Заморозка</a>
                <a href="#">Из мяса</a>
                <a href="#">Компоты</a>
                <a href="#">Маринование</a>
                <p></p>
                <b><a href="#">Десерты</a></b>
                <a href="#">Желе и муссы</a>
                <a href="#">Безе</a>
                <a href="#">Мороженое</a>
                <a href="#">Творожные</a>
                <a href="#">С фруктами</a>
                <a href="#">Конфеты</a>
                <a href="#">Крем-брюлле</a>
                <a href="#">Торты</a>
                <a href="#">Из шоколада</a>
                <a href="#">Мармелад</a>

                <p></p>
                <b><a href="#">Выпечка</a></b>
                <a href="#">Тесто</a>
                <a href="#">Сладкая выпечка</a>
                <a href="#">Несладкая выпечка</a>
                <a href="#">Блины, оладьи</a>
                <a href="#">Выпечка из творога</a>
                <a href="#">Из слоеного теста</a>
            </div>
            <div class="footer_col">
                <b><a href="#">О проекте</a></b>
                <a href="#">Реклама на сайте</a>
                <a href="#">Рецепты блюд</a>
                <a href="#">Статьи</a>
                <a href="#">Кухни мира</a>
                <a href="#">Ингредиенты</a>
                <a href="#">Диеты для худеющих</a>
                <a href="#">Кулинарный форум</a>
                <p></p>
                <b><a href="#">Мы в соц.сетях</a></b>
                <a href="#">Инстраграмм</a>
                <a href="#">Вконтакте</a>
                <a href="#">Facebook</a>
                <a href="#">Одноклассники</a>
                <p></p>
                <b><a href="#">Полезное кулинару</a></b>
                <a href="#">Таблица мер и весов</a>
                <a href="#">Описание частей мяса</a>
                <a href="#">Правила разделки тушек</a>
                <a href="#">Правила очистки овощей</a>
                <a href="#">Способы нарезки</a>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="footer_bottom_left">&copy;2017 na-plite.ru</div>
            <div class="footer_bottom_center"><a href="#">Обратная связь с администрацией</a></div>
            <div class="footer_bottom_right">
                Разработка сайта &mdash; <a href="http://www.alexey-popov.com/" target="_blank">Алексей Попов</a>
            </div>
        </div>
    </div>
</div>

<?php if (Yii::$app->user->isGuest) {
    echo $this->render('@frontend/views/auth/login-modal');
    echo $this->render('@frontend/views/auth/reg-modal');
    echo $this->render('@frontend/views/auth/forgot-password-modal');
} ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
