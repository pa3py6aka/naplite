<?php

/* @var $this yii\web\View */
/* @var $form \core\forms\ContactForm */

?>
Новое сообщение с формы обратной связи с сайте <?= Yii::$app->name ?>:

Тема: <?= $form->subject ?>
email: <?= $form->email ?>
Имя: <?= $form->name ?>

<?= $form->text ?>
