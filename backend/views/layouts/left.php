<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Кухни мира', 'icon' => 'globe', 'url' => ['/kitchen/index'], 'active' => $this->context->id == 'kitchen'],
                    ['label' => 'Категории', 'icon' => 'file-o', 'url' => ['/category/index'], 'active' => $this->context->id == 'category'],
                    ['label' => 'Праздники', 'icon' => 'bookmark', 'url' => ['/holiday/index'], 'active' => $this->context->id == 'holiday'],
                    ['label' => 'Единицы измерения', 'icon' => 'database', 'url' => ['/uom/index'], 'active' => $this->context->id == 'uom'],
                    ['label' => 'Настройки сайта', 'icon' => 'cogs', 'url' => ['/settings/index'], 'active' => $this->context->id == 'settings'],

                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header'], 'visible' => YII_ENV_DEV],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => YII_ENV_DEV],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'visible' => YII_ENV_DEV],
                ],
            ]
        ) ?>

    </section>

</aside>
