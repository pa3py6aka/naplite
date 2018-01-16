<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm', 'token' => $user->email_confirm_token]);
?>
Здравствуйте, для завершения регистрации перейдите по следующей ссылке:

<?= $confirmLink ?>
