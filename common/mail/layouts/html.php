<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

$homeUrl = Yii::$app->urlManager->createAbsoluteUrl('/');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head lang="ru">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::$app->params['frontendHostInfo'] ?>/favicon.ico" type="image/x-icon" />
</head>
<body>
<?php $this->beginBody() ?>
<div style="width:100%;height:100%;background:#f6f6f6;">
    <div style="max-width:650px;clear:both;">
        <div style="clear:both;height:20px;">&nbsp;</div>
        <div style="float:left;width:20px;min-width:50px;">&nbsp;</div>
        <div style="float:left;padding:0px 30px 30px 0px;"><img src="<?= Yii::$app->params['frontendHostInfo'] ?>/img/logo.png" width="282" height="64" alt=""/></div>
    </div>
    <table style="width:650px;max-width:650px;border-collapse:collapse;clear:both;">
        <tr>
            <td style="width:50px;min-width:50px;">&nbsp;</td>
            <td colspan="2">
                <div style="background-color:#ffffff;padding:40px 65px;font-size:16px;font-family:Arial;color:#2e3e48;line-height:29px;border-radius:15px;border-bottom:5px solid #f0efec;">
                    <h1 style="font-family:Arial;font-size:22px;margin:0px 0px 20px 0px;padding:0px;font-weight:600;">
                        <?= Html::encode($this->title) ?>
                    </h1>
                    <?= $content ?>
                </div>
            </td>
            <td style="width:20px;min-width:20px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:20px;min-width:20px;">&nbsp;</td>
            <td colspan="2" style="padding:40px 0px 50px 0px;font-size:14px;font-family:Arial;color:#aeaaa0;">
                &copy; Na-Plite 2017.</td>
            <td style="width:20px;min-width:20px;">&nbsp;</td>
        </tr>
    </table>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
