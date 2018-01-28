<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $recipe \core\entities\Recipe */

$adminLink = Yii::$app->backendUrlManager->createAbsoluteUrl(['recipe/view', 'id' => $recipe->id]);
?>
<div class="password-reset">
    <p><?= Yii::$app->name ?>: добавлен новый рецепт - <?= Html::encode($recipe->name) ?></p>

    <p>
        Просмотреть в админ-панели:<br />
        <?= Html::a(Html::encode($adminLink), $adminLink) ?>
    </p>
</div>
