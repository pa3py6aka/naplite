<?php

/* @var $this \yii\web\View */
/* @var $content string */


use widgets\ModalAlertWidget;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

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
                    <li><a href="<?= Url::to(['/category/view']) ?>"><i class="fa fa-cutlery"></i>Рецепты</a></li>
                    <li class="space"></li>
                    <li><a href="<?= Url::to(['/articles/index']) ?>"><i class="fa fa-info-circle"></i>Статьи</a></li>
                    <li class="space"></li>
                    <li><a href="<?= Url::to(['/kitchens/index']) ?>"><i class="fa fa-globe"></i>Кухни<span class="hidden1260"> мира</span></a></li>
                    <li class="space"></li>
                    <li><a href="<?= Url::to(['/ingredients/index']) ?>"><i class="fa fa-shopping-bag"></i>Ингредиенты</a></li>
                    <li class="space"></li>
                    <li><a href="<?= Url::to(['/articles/index', 'category' => 'diets']) ?>"><i class="fa fa-female"></i>Диеты</a></li>
                    <li class="space"></li>
                    <li><a href="<?= Url::to(['/blog/index']) ?>"><i class="fa fa-comments"></i><span class="hidden1260">Кулинарный</span> Форум</a></li>
                    <li class="space"></li>
                    <li><a href="javascript:void(0)" data-link="weights-search-modal"><i class="fa fa-balance-scale"></i>Таблица мер<span class="hidden1260"> и весов</span></a></li>
                </ul>
            </div>
            <div class="top_panel_right">
                <ul class="not_logged">
                    <li>
                        <a
                            href="<?= Yii::$app->user->isGuest ? 'javascript:void(0)' : Url::to(['/recipes/new']) ?>"
                            class="b_red<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>"
                        >
                            <i class="fa fa-plus"></i>Добавить рецепт
                        </a>
                    </li>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="loginButton"><a href="javascript:void(0)" class="b_green"><i class="fa fa-lock"></i>Войти</a></li>
                    <?php else: ?>
                        <li>
						<span class="top_userpick">
							<span class="top_userpick_inner">
								<span class="top_userpick_photo"><img src="<?= Yii::$app->user->identity->avatarUrl ?>" width="200" height="200" alt=""/></span>
								<span class="top_userpick_arrow"><i class="fa fa-sort-down"></i></span>
							</span>
							<ul>
								<li><a href="<?= Yii::$app->user->identity->pageUrl ?>"><i class="fa fa-user"></i>Личная страница</a></li>
								<li><a href="<?= Url::to(['/users/cookbook', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-book"></i>Кулинарная книга</a></li>
								<!--<li><a href="#"><i class="fa fa-envelope"></i>Сообщения</a></li>-->
								<li><a href="<?= Url::to(['/users/recipes', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-cutlery"></i>Мои рецепты</a></li>
								<li><a href="<?= Url::to(['/users/posts', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-comment"></i>Мои посты</a></li>
								<li><a href="<?= Url::to(['/users/photos', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-photo"></i>Мои фотоотчеты</a></li>
								<li><a href="<?= Url::to(['/users/settings']) ?>"><i class="fa fa-gear"></i>Настройки</a></li>
								<li><a href="<?= Url::to(['/auth/logout']) ?>" data-method="post"><i class="fa fa-sign-out"></i>Выйти</a></li>
							</ul>
						</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="top_bottom" id="mainSearchBlock">
            <div class="top_bottom_left"><a href="/"><img src="/img/logo.png" width="282" height="64" alt=""/></a></div>
            <div class="top_bottom_center">
                <?= Html::beginForm(['/search/index'], 'get', ['id' => 'mainSearchForm']) ?>
                    <div class="top_bottom_center_inner">
                        <div class="top_bottom_center_inner_left autocomplete-styled" id="main-search-block">
                            <?php echo AutoComplete::widget([
                                'name' => 'q',
                                'value' => Yii::$app->request->get('q', ''),
                                'options' => [
                                    'class' => 'main-search-input',
                                    'placeholder' => 'Поиск рецепта...',
                                ],
                                'clientOptions' => [
                                    'source' => new JsExpression("function(request, response) {
                                            $.getJSON('/search/auto-complete', {
                                                value: request.term
                                            }, response);
                                        }"),
                                    'autoFill' => true,
                                    'minLength' => '1',
                                    'appendTo' => '#main-search-block',
                                ]
                            ]);
                            ?>
                            <!--<input name="q" type="text" placeholder="Поиск рецепта..." value="<?= Yii::$app->request->get('q', '') ?>"/>-->
                        </div>
                        <div class="top_bottom_center_inner_right">
                            <a href="javascript:void(0)" data-link="main-search-link" data-type="main">
                                <i class="fa fa-search"></i>
                                <span class="hidden740">Найти</span><span class="hidden1260"> рецепт</span>
                            </a>
                        </div>
                    </div>
                <?= Html::endForm() ?>
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
        <div class="top_adaptive_left"><a href="/"><img src="/img/logo.png" width="282" height="64" alt=""/></a></div>
        <div class="top_adaptive_right">
            <a href="#"><i class="fa fa-bars"></i></a>
            <span class="adaptive_top_menu">
				<ul>
					<li><a href="<?= Url::to(['/category/view']) ?>">Рецепты</a></li>
					<li><a href="<?= Url::to(['/articles/index']) ?>">Статьи</a></li>
					<li><a href="<?= Url::to(['/kitchens/index']) ?>">Кухни мира</a></li>
					<li><a href="<?= Url::to(['/ingredients/index']) ?>">Ингредиенты</a></li>
					<li><a href="<?= Url::to(['/articles/index', 'category' => 'diets']) ?>">Диеты</a></li>
					<li><a href="<?= Url::to(['/blog/index']) ?>">Кулинарный Форум</a></li>
					<li><a href="javascript:void(0)" data-link="weights-search-modal">Таблица мер и весов</a></li>
					<li class="adaptive_top_menu_space"></li>
					<li>
						<ul class="not_logged">
							<li><a href="<?= Yii::$app->user->isGuest ? 'javascript:void(0)' : Url::to(['/recipes/new']) ?>" class="b_red<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>"><i class="fa fa-plus"></i>Добавить рецепт</a></li>
                            <?php if (Yii::$app->user->isGuest): ?>
							    <li class="loginButton"><a href="#" class="b_green"><i class="fa fa-lock"></i>Войти</a></li>
                            <?php else: ?>
                                <!-- login_user -->
                                <li>
                                    <span class="top_userpick">
                                        <span class="top_userpick_inner">
                                            <span class="top_userpick_photo"><img src="<?= Yii::$app->user->identity->avatarUrl ?>" width="200" height="200" alt=""/></span>
                                            <span class="top_userpick_arrow"><i class="fa fa-sort-down"></i></span>
                                        </span>
                                        <ul>
                                            <li><a href="<?= Yii::$app->user->identity->pageUrl ?>"><i class="fa fa-user"></i>Личная страница</a></li>
                                            <li><a href="<?= Url::to(['/users/cookbook', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-book"></i>Кулинарная книга</a></li>
                                            <!--<li><a href="#"><i class="fa fa-envelope"></i>Сообщения</a></li>-->
                                            <li><a href="<?= Url::to(['/users/recipes', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-cutlery"></i>Мои рецепты</a></li>
                                            <li><a href="<?= Url::to(['/users/posts', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-comment"></i>Мои посты</a></li>
                                            <li><a href="<?= Url::to(['/users/photos', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-photo"></i>Мои фотоотчеты</a></li>
                                            <li><a href="<?= Url::to(['/users/settings']) ?>"><i class="fa fa-gear"></i>Настройки</a></li>
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
        <?= Html::beginForm(['/search/index'], 'get', ['id' => 'mainSearchFormAdaptive']) ?>
            <div class="top_bottom_center_inner">
                <div class="top_bottom_center_inner_left">
                    <input name="q" type="text" placeholder="Поиск рецепта..." value="<?= Yii::$app->request->get('q', '') ?>"/>
                </div>
                <div class="top_bottom_center_inner_right">
                    <a href="javascript:void(0)" data-link="main-search-link" data-type="adaptive">
                        <i class="fa fa-search"></i>
                        <span class="hidden740">Найти</span><span class="hidden1260"> рецепт</span>
                    </a>
                </div>
            </div>
        <?= Html::endForm() ?>
    </div>
</div>
<div class="top_menu_outer">
    <div class="top_menu">
        <a href="#" class="top_menu_adaptive"><i class="fa fa-bars"></i>&nbsp;Открыть список рецептов</a>
        <ul>
            <li class="top_menu_arrow_left hidden1260"></li>
            <?php $activeSlug = isset($this->params['activeCategorySlug']) ? $this->params['activeCategorySlug'] : null ?>
            <?php foreach (\core\entities\Recipe\Category::find()->where(['depth' => 1])->all() as $k => $category): ?>
                <li<?= $k > 8 ? ' class="hidden880"' : '' ?>>
                    <a href="<?= Url::to(['/category/view', 'slug' => $category->slug]) ?>"<?= $activeSlug == $category->slug ? ' class="top_menu_active"' : '' ?>>
                        <?= $category->name ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="top_menu_arrow_right hidden1260"></li>
        </ul>
    </div>
</div>

<?php if (Yii::$app->settings->get('bannerDirectUnderMenu_show')) {
    echo Yii::$app->settings->get('bannerDirectUnderMenu');
} ?>

<div class="wrap">
    <div class="content">
        <?= $content ?>
    </div>
</div>
<div class="footer">
    <div class="wrap">
        <div class="footer_top">
            <?= Yii::$app->settings->get('footer') ?>
        </div>
        <div class="footer_bottom">
            <div class="footer_bottom_left">&copy;2018<?= date('Y') > 2018 ? ' - ' . date('Y') : '' ?> na-plite.ru</div>
            <div class="footer_bottom_center"><a href="<?= Url::to(['/site/contact']) ?>">Обратная связь с администрацией</a></div>
            <div class="footer_bottom_right">
                Разработка сайта &mdash; <a href="http://www.alexey-popov.com/" target="_blank">Алексей Попов</a>
            </div>
        </div>
    </div>
</div>

<?= $this->render('message-modal') ?>
<?= $this->render('@frontend/views/weights/weights-modal') ?>
<?= ModalAlertWidget::widget() ?>

<?php if (Yii::$app->user->isGuest) {
    echo $this->render('@frontend/views/auth/login-modal');
    echo $this->render('@frontend/views/auth/reg-modal');
    echo $this->render('@frontend/views/auth/forgot-password-modal');

    if (Yii::$app->request->get('login') == '1') {
        $this->registerJs('window.addEventListener("load", function(){$(".loginButton").click();});');
    } else if (Yii::$app->request->get('signup') == 'show') {
        $this->registerJs('window.addEventListener("load", function(){$(".regButton").click();});');
    }
} ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
