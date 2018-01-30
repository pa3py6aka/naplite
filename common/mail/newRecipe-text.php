<?php

/* @var $this yii\web\View */
/* @var $recipe \core\entities\Recipe\Recipe */

$adminLink = Yii::$app->backendUrlManager->createAbsoluteUrl(['recipe/view', 'id' => $recipe->id]);
?>
<?= Yii::$app->name ?>: добавлен новый рецепт - <?= \yii\helpers\Html::encode($recipe->name) ?>

Просмотреть в админ-панели:
<?= $adminLink ?>
