<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);
$this->title = "Сброс пароля";
?>
<p>Перейдите по этой ссылке для восстановления пароля:</p>
<p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
