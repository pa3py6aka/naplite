<?php
/* @var $ingredients \core\entities\Ingredient\Ingredient[] */

use core\helpers\ContentHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="textbox">
    <h2>Кулинарные ингредиенты</h2>
    <ul class="ingredients">
        <?php foreach ($ingredients as $ingredient): ?>
        <li>
            <a href="<?= $ingredient->getUrl() ?>" class="ingredients_photo">
                <img src="<?= $ingredient->getImageUrl() ?>" width="231" height="148" alt="<?= Html::encode($ingredient->title) ?>"/>
            </a>
            <a href="<?= $ingredient->getUrl() ?>"><?= Html::encode($ingredient->title) ?></a>
            <?= ContentHelper::output($ingredient->prev_text) ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="tac">
        <a href="<?= Url::to(['/ingredients/index']) ?>" class="b_white"><i class="fa fa-refresh"></i>Узнать больше об ингредиентах</a>
    </div>
</div>
