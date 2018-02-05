<?php

/* @var $this yii\web\View */
/* @var $form \core\forms\ContactForm */

?>
Новое сообщение с формы обратной связи с сайте <?= Yii::$app->name ?>:<br /><br />

Тема: <?= $form->subject ?><br />
email: <?= $form->email ?><br />
Имя: <?= $form->name ?><br /><br />

<?= $form->text ?>
