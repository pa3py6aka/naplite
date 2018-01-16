<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm', 'token' => $user->email_confirm_token]);
?>
Здравствуйте, для завершения регистрации перейдите по следующей ссылке:

<?= $confirmLink ?>
