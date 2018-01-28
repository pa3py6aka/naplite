<?php
/* @var $categories \core\entities\Blog\BlogCategory[] */
/* @var $activeCategory \core\entities\Blog\BlogCategory|null */

use yii\helpers\Url;

?>
<div class="right_menu">
    <ul>
        <li>
            <a href="<?= Url::to(['/blog/index']) ?>"<?= !$activeCategory ? ' class="right_menu_active"' : '' ?>>
                Все публикации
            </a>
        </li>
        <?php foreach ($categories as $category): ?>
            <li>
                <a
                    href="<?= Url::to(['/blog/index', 'category' => $category->slug]) ?>"
                    <?= $activeCategory && $category->id == $activeCategory->id ? ' class="right_menu_active"' : '' ?>
                >
                    <?= $category->name ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
