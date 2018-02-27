<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $recipe \core\entities\Recipe\Recipe */

$adminLink = Yii::$app->backendUrlManager->createAbsoluteUrl(['recipe/view', 'id' => $recipe->id]);
$this->title = "Новый рецепт";
?>
<p><?= Yii::$app->name ?>: добавлен новый рецепт - <?= Html::encode($recipe->name) ?></p>
<p>
    Просмотреть в админ-панели:<br />
    <?= Html::a(Html::encode($adminLink), $adminLink) ?>
</p>
