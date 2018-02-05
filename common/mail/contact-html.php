<?php

/* @var $this yii\web\View */
/* @var $form \core\forms\ContactForm */

?>
<h3>Новое сообщение с формы обратной связи</h3>
Тема: <?= $form->subject ?>
email: <?= $form->email ?>
Имя: <?= $form->name ?>

<?= $form->text ?>
