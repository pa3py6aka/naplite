<?php
/* @var $recipesProvider \yii\data\ActiveDataProvider */

use core\entities\Recipe\Recipe;
use core\helpers\RecipeHelper;
use widgets\Pager;
use yii\helpers\Html;

?>
<ul class="catalogue_ul">
    <?php foreach ($recipesProvider->models as $recipe): ?>
        <?= $this->render('@frontend/views/recipes/recipe-item', ['recipe' => $recipe]) ?>
    <?php endforeach; ?>
</ul>

<?php if (Yii::$app->settings->get('bannerPagenator_show')) {
    echo Yii::$app->settings->get('bannerPagenator');
} ?>

<?= Pager::widget(['pagination' => $recipesProvider->pagination]) ?>
