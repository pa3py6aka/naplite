<?php

use core\entities\Kitchen;
use core\entities\Recipe\Recipe;
use core\forms\manage\CategoryForm;
use frontend\assets\RecipeCreatorAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \core\forms\RecipeForm */
/* @var $recipe null|\core\entities\Recipe\Recipe */

RecipeCreatorAsset::register($this);
$this->title = $recipe ? "Редактирование рецепта" : "Добавление рецепта";
$data = \core\entities\Uom::find()
    ->select(['name as value', 'name as label', 'id'])
    //->select(['name'])
    ->asArray()
    ->all();

$jsData = [];
foreach ($data as $item) {
    $jsData[] = $item['value'];
}

?>
<script type="text/javascript">
    var ingredientsUom = <?= Json::encode($jsData) ?>;
</script>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="/">Главная</a>
                <span><i class="fa fa-circle"></i></span>
                <a href="<?= Url::to(['/users/settings']) ?>">Личный кабинет</a>
            </div>
            <h1><?= $recipe ? Html::encode($recipe->name) : "Ваш новый рецепт" ?></h1>
        </div>
        <div class="form_center" id="recipe-form">
            <?php $form = ActiveForm::begin(['id' => 'recipeForm']) ?>
                <div class="inputbox">
                    <div class="inputbox_label">Название рецепта:</div>

                    <?= $form->field($model, 'name', ['options' => ['class' => 'inputbox_input']])
                        ->textInput(['class' => 'input_base', 'placeholder' => 'Введите название рецепта'])
                        ->label(false) ?>

                </div>
                <div class="inputbox_2_col">
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Категория рецепта:</div>

                        <?= $form->field($model, 'categoryId', ['options' => ['class' => 'inputbox_input']])
                            ->dropDownList(CategoryForm::parentCategoriesList(false), ['class' => 'select_base', 'prompt' => 'Выберите'])
                            ->label(false) ?>

                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Национальная кухня:</div>

                        <?= $form->field($model, 'kitchenId', ['options' => ['class' => 'inputbox_input']])
                            ->dropDownList(ArrayHelper::map(Kitchen::find()->asArray()->all(), 'id', 'name'), ['class' => 'select_base', 'prompt' => 'Выберите'])
                            ->label(false) ?>

                    </div>
                </div>

                <?php if (is_array($model->photos)) {
                    foreach ($model->photos as $n => $photo): ?>
                        <div class="uploadbox_big">
                            <a href="javascript:void(0)" class="ico-main<?= $model->mainPhoto == $n ? ' active' : '' ?>" title="Сделать главной"><i class="fa fa-check-circle-o"></i></a>
                            <a href="javascript:void(0)" class="ico-close" title="Удалить фотографию"><i class="fa fa-close"></i></a>
                            <a href="javascript:void(0)" class="upload-link">
                                <img src="/photos/<?= $photo ?>">
                                <i class="fa fa-photo" style="display:none;"></i>
                                <span style="display:none;">Загрузите фото рецепта</span>
                                <div class="hidden default-text">Загрузите фото рецепта</div>
                                <input type="file" class="hidden upload-file" accept="image/*" multiple>
                                <?= Html::activeHiddenInput($model, 'photos[' . $n . ']', ['data' => ['num' => $n]]) ?>
                            </a>
                        </div>
                    <?php endforeach;
                } else { ?>
                    <div class="uploadbox_big">
                        <a href="javascript:void(0)" class="upload-link">
                            <i class="fa fa-photo"></i>
                            <span>Загрузите фото рецепта</span>
                            <div class="hidden default-text">Загрузите фото рецепта</div>
                            <input type="file" class="hidden upload-file" accept="image/*" multiple>
                            <?= Html::activeHiddenInput($model, 'photos[0]', ['data' => ['num' => 0]]) ?>
                        </a>
                    </div>
                <?php } ?>
                <?= Html::activeHiddenInput($model, 'mainPhoto', ['id' => 'main-photo-num']) ?>

                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Вводный текст:</div>
                            <!--<div class="inputbox_label_right"><img src="/img/wsw.jpg" width="155" height="19" alt=""/></div>-->
                        </div>
                    </div>

                    <?= $form->field($model, 'introductoryText', ['options' => ['class' => 'inputbox_input']])
                        ->textarea([
                            'id' => 'introductoryTextArea',
                            'cols' => 2,
                            'rows' => 2,
                            'class' => 'textarea_base',
                            'placeholder' => 'Напишите пару предложений о рецепте и его особенностях'
                        ])
                        ->label(false) ?>

                </div>
                <div class="inputbox_3_col">
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Время приготовления:</div>
                        <div class="inputbox_input">
                            <div class="hours-block">
                                <div class="time-control" data-direction="up" data-type="hours"><i class="fa fa-angle-up"></i></div>
                                <?= Html::activeInput('text', $model, 'cookingTimeHours', ['class' => 'input_base']) ?>
                                <div class="time-control" data-direction="down" data-type="hours"><i class="fa fa-angle-down"></i></div>
                            </div>
                            <!--<div style="display:inline-block;width:7px;text-align:center"><div style="height:100%;margin:auto;">:</div></div>-->
                            <div class="minutes-block">
                                <div class="time-control" data-direction="up" data-type="minutes"><i class="fa fa-angle-up"></i></div>
                                <?= Html::activeInput('text', $model, 'cookingTimeMinutes', ['class' => 'input_base input-small']) ?>
                                <div class="time-control" data-direction="down" data-type="minutes"><i class="fa fa-angle-down"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Нужна ли подготовка:</div>
                        <div class="inputbox_input">
                            <div class="hours-block">
                                <div class="time-control" data-direction="up" data-type="hours"><i class="fa fa-angle-up"></i></div>
                                <?= Html::activeInput('text', $model, 'preparationTimeHours', ['class' => 'input_base']) ?>
                                <div class="time-control" data-direction="down" data-type="hours"><i class="fa fa-angle-down"></i></div>
                            </div>
                            <!--<div style="display:inline-block;width:7px;text-align:center"><div style="height:100%;margin:auto;">:</div></div>-->
                            <div class="minutes-block">
                                <div class="time-control" data-direction="up" data-type="minutes"><i class="fa fa-angle-up"></i></div>
                                <?= Html::activeInput('text', $model, 'preparationTimeMinutes', ['class' => 'input_base input-small']) ?>
                                <div class="time-control" data-direction="down" data-type="minutes"><i class="fa fa-angle-down"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Количество персон:</div>

                        <?= $form->field($model, 'persons', ['options' => ['class' => 'inputbox_input']])
                            ->dropDownList($model->personsArray(), ['class' => 'select_base'])
                            ->label(false) ?>

                    </div>
                </div>
                <div class="inputbox_2_col">
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Для какого праздника?</div>

                        <?= $form->field($model, 'holidaysInput', ['options' => ['class' => 'inputbox_input']])
                            ->textInput(['class' => 'select_base', 'disabled' => false, 'id' => 'holiday-input'])
                            ->label(false) ?>

                        <?= $this->render('holidays-modal', ['form' => $form, 'model' => $model]) ?>

                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Сложность рецепта:</div>

                        <?= $form->field($model, 'complexity', ['options' => ['class' => 'inputbox_input']])
                            ->dropDownList(Recipe::complexities(), ['class' => 'select_base', 'prompt' => 'Выберите'])
                            ->label(false) ?>

                    </div>
                </div>
                <div class="p40"></div>
                <?php for ($n = 0; $n < (($model->ingredientSection && is_array($model->ingredientSection) && count($model->ingredientSection)) ? count($model->ingredientSection) : 1); $n++): ?>
                <div class="add_ing_box" data-num="<?= $n ?>">
                    <div class="cb">
                        <h3>Ингредиенты</h3>
                        <div class="add_ing_descr hint">
                            Введите название списка. Например: Для теста
                        </div>
                        <?= Html::activeTextInput($model, 'ingredientSection[' . $n . ']', ['class' => 'input_base', 'placeholder' => 'Основные ингредиенты']) ?>
                    </div>
                    <div class="add_ing_descr hint">
                        <br />Введите название ингредиента, количество и меру.<br />
                        Например лук репчатый 1 пучок, томатная паста 0.25 л.
                    </div>
                    <?php for ($i = 0; $i < ((isset($model->ingredientName[$n]) && is_array($model->ingredientName[$n]) && count($model->ingredientName[$n])) ? count($model->ingredientName[$n]) + 1 : 4); $i++): ?>
                        <div class="add_ing_inputs">
                        <div class="add_ing_inputs_box_1">
                            <div class="inputbox_input">
                                <?= Html::activeTextInput($model, 'ingredientName[' . $n . '][' . $i . ']', [
                                    'class' => 'input_base',
                                    'placeholder' => 'Название',
                                    'data' => ['num' => $i],
                                ]) ?>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_2">
                            <div class="inputbox_input">
                                <?= Html::activeTextInput($model, 'ingredientQuantity[' . $n . '][' . $i . ']', ['class' => 'input_base', 'placeholder' => 'Кол-во']) ?>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_3">
                            <div class="inputbox_input">
                                <?php echo AutoComplete::widget([
                                    'name' => $model->formName() . '[ingredientUom][' . $n . '][' . $i . ']',
                                    'id' => 'uom-' . $n . '-' . $i,
                                    'value' => isset($model->ingredientUom[$n][$i]) ? $model->ingredientUom[$n][$i] : '',
                                    'options' => [
                                        'class' => 'input_base',
                                        'placeholder' => 'Ед.',
                                    ],
                                    'clientOptions' => [
                                        'source' => $data,
                                        'autoFill'=>true,
                                        'minLength'=>'0'
                                    ]]);
                                ?>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_4">
                            <a href="javascript:void(0)" data-button="removeIngredient"><i class="fa fa-ban"></i></a>
                        </div>
                    </div>
                    <?php endfor; ?>
                    <div class="add_ing_bottom">
                        <div class="add_ing_bottom_left"><a href="javascript:void(0)" class="b_gray" data-button="addIngredientSection"><i class="fa fa-list"></i>Добавить еще</a></div>
                        <div class="add_ing_bottom_right">Например, ингредиенты для соуса</div>
                    </div>
                    <a href="javascript:void(0)" class="ico_trash" data-button="removeSection"><i class="fa fa-trash"></i></a>
                </div>
                <?php endfor; ?>
                <div class="p40"></div>
                <div class="add_steps">
                    <div class="add_steps_th"><h3>Способ приготовления</h3></div>
                    <?php for ($i = 1; $i <= ((is_array($model->stepDescription) && count($model->stepDescription)) ? count($model->stepDescription) : 2); $i++): ?>
                    <div class="add_steps_box" data-num="<?= $i ?>">
                        <div class="add_steps_box_left">
                            <div class="inputbox_label">
                                <div class="inputbox_label_2col">
                                    <div class="inputbox_label_left">Шаг <?= $i ?>:</div>
                                    <!--<div class="inputbox_label_right"><img src="/img/wsw.jpg" width="155" height="19" alt=""/></div>-->
                                </div>
                            </div>
                            <div class="inputbox_input">
                                <?= Html::activeTextarea($model, 'stepDescription[' . $i . ']', [
                                    'class' => 'textarea_base',
                                    'placeholder' => 'Опишите шаг приготовления',
                                    'cols' => 2,
                                    'rows' => 2,
                                ]) ?>
                            </div>
                        </div>
                        <div class="add_steps_box_rasp"></div>
                        <div class="add_steps_box_right">
                            <div class="uploadbox_small">
                                <?php if (isset($model->stepPhoto[$i])): ?>
                                    <a href="javascript:void(0)" class="upload-link">
                                        <img src="/photos/<?= $model->stepPhoto[$i] ?>">
                                        <i class="fa fa-photo" style="display:none;"></i>
                                        <span style="display:none;">Нажмите, чтобы <br />добавить фото</span>
                                        <div class="hidden default-text">Нажмите, чтобы <br />добавить фото</div>
                                        <input type="file" class="hidden upload-file" accept="image/*">
                                        <?= Html::activeHiddenInput($model, 'stepPhoto[' . $i . ']') ?>
                                    </a>
                                <?php else: ?>
                                    <a href="javascript:void(0)" class="upload-link">
                                        <i class="fa fa-photo"></i>
                                        <span>Нажмите, чтобы <br />добавить фото</span>
                                        <div class="hidden default-text">Нажмите, чтобы <br />добавить фото</div>
                                        <input type="file" class="hidden upload-file" accept="image/*">
                                        <?= Html::activeHiddenInput($model, 'stepPhoto[' . $i . ']') ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                    <div class="add_steps_bottom">
                        <a href="javascript:void(0)" class="b_gray" data-button="addStep"><i class="fa fa-plus-circle"></i>Добавить еще один шаг</a>
                    </div>
                </div>
                <div class="p40"></div>
                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Хозяйке на заметку:</div>
                            <!--<div class="inputbox_label_right"><img src="img/wsw.jpg" width="155" height="19" alt=""/></div>-->
                        </div>
                    </div>

                    <?= $form->field($model, 'notes', ['options' => ['class' => 'inputbox_input']])
                        ->textarea([
                            'id' => 'notesArea',
                            'cols' => 2,
                            'rows' => 2,
                            'class' => 'textarea_base',
                            'placeholder' => 'Напишите какой-нибудь совет, тем, кто будет готовить ваш рецепт'
                        ])
                        ->label(false) ?>

                </div>
                <div class="add_recipe_bottom">
                    <a href="javascript:void(0)" class="b_red" data-button="submitForm"><i class="fa fa-plus"></i><?= $recipe ? "Сохранить" : "Добавить" ?> рецепт</a>
                </div>
                <?= Html::activeHiddenInput($model, 'commentsNotify', ['id' => 'commentsNotify']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<div class="content_right">
    <div class="rightbox_nop">
        <div class="switch_top">
            <div class="right_preview_th"><b>Предварительный просмотр</b></div>
            <!--Если переключатель включен дописывается в див "right_preview_switch switch_on"-->
            <div class="right_preview_switch">
                <div class="right_preview_switch_left">ВКЛ</div>
                <div class="right_preview_switch_center">
                    <span class="right_preview_switch_center_inner">
                        <a href="#" class="right_preview_switch_center_left switch_on_left"><i class="fa fa-eye"></i></a>
                        <a href="#" class="right_preview_switch_center_right"><span></span></a>
                    </span>
                </div>
                <div class="right_preview_switch_right">ВЫКЛ</div>
            </div>
        </div>
        <div class="swith_bottom">
            <div class="radiobox_input">
                <div class="checkbox_outer">
                    <input type="checkbox" id="commentsNotifyVisibleInput" name="commentsNotifyVisibleInput" value="1" class="checkbox"<?= $model->commentsNotify ? ' checked' : '' ?>>
                    <label id="commentsNotifyVisibleInput_label" for="commentsNotifyVisibleInput">
                        Получать комментарии к рецепту на почту
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
