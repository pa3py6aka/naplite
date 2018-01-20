<?php
use core\entities\Holiday;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $model \core\forms\RecipeForm */
/* @var $form \yii\widgets\ActiveForm */

?>
<div class="modalbox" id="holidaysModal">
    <div class="modal_outer adaptive_message">
        <div class="modal_inner">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Праздники</h1>
                    Выберите подходящие праздники:
                </div>
                <div class="modals_hr"></div>

                <div class="modal_inputbox">

                    <?php foreach (Holiday::find()->all() as $holiday): ?>
                        <div class="checkbox_outer">
                            <input
                                    type="checkbox"
                                    id="filter_product_country<?= $holiday->id ?>"
                                    name="<?= $model->formName() ?>[holidays][<?= $holiday->id ?>]"
                                    value="<?= $holiday->id ?>"
                                    class="checkbox"
                                    <?= (isset($model->holidays[$holiday->id]) && $model->holidays[$holiday->id] == $holiday->id) ? 'checked' : '' ?>
                            >
                            <label id="filter_product_country_label<?= $holiday->id ?>" for="filter_product_country<?= $holiday->id ?>">
                                <?= $holiday->name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <div class="radio_and_but">
                        <button type="button" class="radio_and_but_right blind-button modalClose"><a type="button" class="b_red">Готово</a></button>
                    </div>
                </div>
                <div class="p40"></div>
            </div>
        </div>
    </div>
</div>
