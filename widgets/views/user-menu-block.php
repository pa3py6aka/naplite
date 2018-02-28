<?php
/* @var int $userId */
/* @var string $action */

use widgets\UserRightMenuWidget;

?>
<div class="right_menu">
    <ul>
        <li><a href="<?= Yii::$app->user->identity->pageUrl ?>"<?= $action == 'view' ? ' class="right_menu_active"' : '' ?>>Личная страница</a></li>
        <li><?= UserRightMenuWidget::getUrl('cookbook', $action, $userId, 'Кулинарная книга') ?></li>
        <!-- ToDo : Личные сообщения
        <li><a href="#">Сообщения</a></li>-->
        <li><?= UserRightMenuWidget::getUrl('recipes', $action, $userId, 'Мои рецепты') ?></li>
        <li><?= UserRightMenuWidget::getUrl('posts', $action, $userId, 'Мои посты') ?></li>
        <li><?= UserRightMenuWidget::getUrl('photos', $action, $userId, 'Мои фотоотчеты') ?></li>
        <li><?= UserRightMenuWidget::getUrl('settings', $action, $userId, 'Настройки') ?></li>
    </ul>
</div>
