<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);
$this->title = "Сброс пароля";
?>
<?= str_replace('{LINK}', $confirmLink, Yii::$app->settings->get('passwordResetBody')) ?>
