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
<--BODY-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
