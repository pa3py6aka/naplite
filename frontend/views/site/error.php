<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <br><br>
    <?php if ($name == 'Exception'): ?>

    <?php else: ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php endif; ?>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
