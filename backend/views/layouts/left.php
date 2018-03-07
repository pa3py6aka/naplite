<?php
$menu = Yii::$app->user->can(\core\access\Rbac::ROLE_ADMIN) ?
    [
        ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user/index'], 'active' => $this->context->id == 'user'],
        ['label' => 'Меню рецептов', 'options' => ['class' => 'header']],
        ['label' => 'Рецепты', 'icon' => 'cutlery', 'url' => ['/recipe/index'], 'active' => $this->context->id == 'recipe'],
        ['label' => 'Подборки', 'icon' => 'server', 'url' => ['/collection/index'], 'active' => $this->context->id == 'collection'],
        ['label' => 'Фотоотчёты', 'icon' => 'photo', 'url' => ['/photo-report/index'], 'active' => $this->context->id == 'photo-report'],
        ['label' => 'Кухни мира', 'icon' => 'globe', 'url' => ['/kitchen/index'], 'active' => $this->context->id == 'kitchen'],
        ['label' => 'Категории', 'icon' => 'folder', 'url' => ['/category/index'], 'active' => $this->context->id == 'category'],
        ['label' => 'Праздники', 'icon' => 'bookmark', 'url' => ['/holiday/index'], 'active' => $this->context->id == 'holiday'],
        ['label' => 'Единицы измерения', 'icon' => 'database', 'url' => ['/uom/index'], 'active' => $this->context->id == 'uom'],

        ['label' => 'Меню статей', 'options' => ['class' => 'header']],
        ['label' => 'Статьи', 'icon' => 'book', 'url' => ['/article/index'], 'active' => $this->context->id == 'article'],
        ['label' => 'Категории', 'icon' => 'folder', 'url' => ['/article-category/index'], 'active' => $this->context->id == 'article-category'],
        ['label' => 'Топ-блок', 'icon' => 'star-o', 'url' => ['/article-top/index'], 'active' => $this->context->id == 'article-top'],

        ['label' => 'Меню блога', 'options' => ['class' => 'header']],
        ['label' => 'Посты', 'icon' => 'file-audio-o', 'url' => ['/blog/index'], 'active' => $this->context->id == 'blog'],
        ['label' => 'Категории', 'icon' => 'folder', 'url' => ['/blog-category/index'], 'active' => $this->context->id == 'blog-category'],

        ['label' => 'Меню ингредиентов', 'options' => ['class' => 'header']],
        ['label' => 'Ингредиенты', 'icon' => 'shopping-bag', 'url' => ['/ingredient/index'], 'active' => $this->context->id == 'ingredient'],
        ['label' => 'Категории', 'icon' => 'folder', 'url' => ['/ingredient-category/index'], 'active' => $this->context->id == 'ingredient-category'],

        ['label' => 'Разное', 'options' => ['class' => 'header']],
        ['label' => 'Таблица мер и весов', 'icon' => 'balance-scale', 'url' => ['/weight/index'], 'active' => $this->context->id == 'weight'],
        ['label' => 'Настройки сайта', 'icon' => 'cogs', 'url' => ['/settings/index']],
        ['label' => 'Настройки e-mail', 'icon' => 'envelope', 'url' => ['/settings/emails']],

        [
            'label' => 'Выйти',
            'url' => ['/site/logout'],
            'template' => '<a href="{url}" data-method="POST"><i class="fa fa-sign-out"></i>{label}</a>'
        ],

        ['label' => 'Menu Yii2', 'options' => ['class' => 'header'], 'visible' => YII_ENV_DEV],
        ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => YII_ENV_DEV],
        ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'visible' => YII_ENV_DEV],
    ]
    :
    [
        ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/user/index'], 'active' => $this->context->id == 'user'],
        ['label' => 'Рецепты', 'icon' => 'cutlery', 'url' => ['/recipe/index'], 'active' => $this->context->id == 'recipe'],
        ['label' => 'Фотоотчёты', 'icon' => 'photo', 'url' => ['/photo-report/index'], 'active' => $this->context->id == 'photo-report'],
        ['label' => 'Посты', 'icon' => 'file-audio-o', 'url' => ['/blog/index'], 'active' => $this->context->id == 'blog'],
        [
            'label' => 'Выйти',
            'url' => ['/site/logout'],
            'template' => '<a href="{url}" data-method="POST"><i class="fa fa-sign-out"></i>{label}</a>'
        ],
    ];


?>

<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menu,
            ]
        ) ?>

    </section>

</aside>
