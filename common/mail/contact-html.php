<?php

/* @var $this yii\web\View */
/* @var $form \core\forms\ContactForm */

$this->title = "Новое сообщение с формы обратной связи";

?>
Тема: <?= $form->subject ?><br />
email: <?= $form->email ?><br />
Имя: <?= $form->name ?><br />
<br />
<?= $form->text ?>
