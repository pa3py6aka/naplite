<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm', 'token' => $user->email_confirm_token]);
$this->title = "Подтверждение регистрации";
?>
<?= str_replace('{LINK}', $confirmLink, Yii::$app->settings->get('emailConfirmBody')) ?>
