<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

$homeUrl = Yii::$app->urlManager->createAbsoluteUrl('/');

?>
<?php $this->beginPage() ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="background-color:#eeeeee;font-family:Arial, San-Seriff;font-size:15px;color:#31312e;margin:40px 30px;">
    <?php $this->beginBody() ?>
    <table style="clear:both;width:80%;clear:both;border-collapse:collapse;border-spacing:0;margin-left:45px;">
        <tr>
            <td style="background-color:#ffffff;padding:15px 0px 10px 40px;border:0px;width:300px;"><a href="<?= $homeUrl ?>"><img src="<?= Yii::$app->params['frontendHostInfo'] ?>/img/logo.png" width="282" height="64" alt=""/></a></td>
            <td style="background-color:#1b1b1b;color:#ffffff;"><b></b></td>
        </tr>
        <tr><td colspan="2" style="height:15px;"></td></tr>
        <?= nl2br($content) ?>
        <tr><td colspan="2" style="height:15px;"></td></tr>
        <tr>
            <td colspan="2" style="font-size:13px;line-height:20px;padding:0px 0px 15px 40px;">
                Вы получили это письмо так как зарегистрированы на сайте <a href="<?= $homeUrl ?>" style="color:#704f35;">www.na-plite.ru</a><br />
                Для того чтобы отписаться от всех сообщений кроме важных системных уведомлений нажмите здесь
            </td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
