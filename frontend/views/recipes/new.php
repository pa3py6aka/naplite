<?php
/* @var $this \yii\web\View */

?>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="#">Главная</a>
                <span><i class="fa fa-circle"></i></span>
                <a href="#">Личный кабинет</a>
            </div>
            <h1>Ваш новый рецепт</h1>
        </div>
        <div class="form_center">
            <form action="sdfgsdfg.php" method="post">
                <div class="inputbox">
                    <div class="inputbox_label">Название рецепта:</div>
                    <div class="inputbox_input"><input type="text" class="input_base" placeholder="Введите название рецепта" /></div>
                </div>
                <div class="inputbox_2_col">
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Категория рецепта:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите категорию</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Национальная кухня:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите кухню мира</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="uploadbox_big">
                    <a href="#">
                        <i class="fa fa-photo"></i>
                        <span>Загрузите фото рецепта</span>
                    </a>
                </div>
                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Вводный текст:</div>
                            <div class="inputbox_label_right"><img src="img/wsw.jpg" width="155" height="19" alt=""/></div>
                        </div>
                    </div>
                    <div class="inputbox_input">
                        <textarea cols="2" rows="2" class="textarea_base" placeholder="Напишите пару предложений о рецепте и его особенностях"></textarea>
                    </div>
                </div>
                <div class="inputbox_3_col">
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Время приготовления:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите</option>
                                <option value="2">5 мин</option>
                                <option value="2">15 мин</option>
                                <option value="2">30 мин</option>
                                <option value="2">45 мин</option>
                                <option value="2">1 час</option>
                                <option value="2">1,5 часа</option>
                                <option value="2">2 часа</option>
                                <option value="2">2,5 часа</option>
                                <option value="2">3 часа</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Нужна ли подготовка:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите</option>
                                <option value="2">Да</option>
                                <option value="2">Нет</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_3_col_box">
                        <div class="inputbox_label">Количество персон:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите</option>
                                <option value="2">1</option>
                                <option value="2">2</option>
                                <option value="2">3</option>
                                <option value="2">4</option>
                                <option value="2">5</option>
                                <option value="2">6</option>
                                <option value="2">7</option>
                                <option value="2">8</option>
                                <option value="2">9</option>
                                <option value="2">10</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="inputbox_2_col">
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Для какого праздника?</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите повод</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputbox_2_col_rasp"></div>
                    <div class="inputbox_2_col_box">
                        <div class="inputbox_label">Сложность рецепта:</div>
                        <div class="inputbox_input">
                            <select name="sdfgwegsdf" class="select_base">
                                <option value="2">Выберите</option>
                                <option value="2">Легко</option>
                                <option value="2">Средне</option>
                                <option value="2">Сложно</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p40"></div>
                <div class="add_ing_box">
                    <div class="cb">
                        <h3>Ингредиенты</h3>
                        <div class="add_ing_descr hint">
                            Введите название списка. Например: Для теста
                        </div>
                        <input type="text" class="input_base" placeholder="Основные ингредиенты" />
                    </div>
                    <div class="add_ing_descr hint">
                        <br />Введите название ингредиента, количество и меру.<br />
                        Например лук репчатый 1 пучок, томатная паста 0.25 л.
                    </div>
                    <div class="add_ing_inputs">
                        <div class="add_ing_inputs_box_1">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Название" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_2">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Кол-во" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_3">
                            <div class="inputbox_input">
                                <select name="sdfgwegsdf" class="select_base">
                                    <option value="2">Ед.</option>
                                </select>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_4">
                            <a href="#"><i class="fa fa-ban"></i></a>
                        </div>
                    </div>
                    <div class="add_ing_inputs">
                        <div class="add_ing_inputs_box_1">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Название" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_2">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Кол-во" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_3">
                            <div class="inputbox_input">
                                <select name="sdfgwegsdf" class="select_base">
                                    <option value="2">Ед.</option>
                                </select>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_4">
                            <a href="#"><i class="fa fa-ban"></i></a>
                        </div>
                    </div>
                    <div class="add_ing_inputs">
                        <div class="add_ing_inputs_box_1">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Название" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_2">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Кол-во" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_3">
                            <div class="inputbox_input">
                                <select name="sdfgwegsdf" class="select_base">
                                    <option value="2">Ед.</option>
                                </select>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_4">
                            <a href="#"><i class="fa fa-ban"></i></a>
                        </div>
                    </div>
                    <div class="add_ing_inputs">
                        <div class="add_ing_inputs_box_1">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Название" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_2">
                            <div class="inputbox_input">
                                <input type="text" class="input_base" placeholder="Кол-во" />
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_3">
                            <div class="inputbox_input">
                                <select name="sdfgwegsdf" class="select_base">
                                    <option value="2">Ед.</option>
                                </select>
                            </div>
                        </div>
                        <div class="add_ing_inputs_box_rasp"></div>
                        <div class="add_ing_inputs_box_4">
                            <a href="#"><i class="fa fa-ban"></i></a>
                        </div>
                    </div>
                    <div class="add_ing_bottom">
                        <div class="add_ing_bottom_left"><a href="#" class="b_gray"><i class="fa fa-list"></i>Добавить еще</a></div>
                        <div class="add_ing_bottom_right">Например, ингредиенты для соуса</div>
                    </div>
                    <a href="#" class="ico_trash"><i class="fa fa-trash"></i></a>
                </div>
                <div class="p40"></div>
                <div class="add_steps">
                    <div class="add_steps_th"><h3>Способ приготовления</h3></div>
                    <div class="add_steps_box">
                        <div class="add_steps_box_left">
                            <div class="inputbox_label">
                                <div class="inputbox_label_2col">
                                    <div class="inputbox_label_left">Шаг 1:</div>
                                    <div class="inputbox_label_right"><img src="img/wsw.jpg" width="155" height="19" alt=""/></div>
                                </div>
                            </div>
                            <div class="inputbox_input">
                                <textarea cols="2" rows="2" class="textarea_base" placeholder="Опишите шаг приготовления"></textarea>
                            </div>
                        </div>
                        <div class="add_steps_box_rasp"></div>
                        <div class="add_steps_box_right">
                            <div class="uploadbox_small">
                                <a href="#">
                                    <i class="fa fa-photo"></i>
                                    <span>Нажмите, чтобы <br />добавить фото</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="add_steps_box">
                        <div class="add_steps_box_left">
                            <div class="inputbox_label">
                                <div class="inputbox_label_2col">
                                    <div class="inputbox_label_left">Шаг 2:</div>
                                    <div class="inputbox_label_right"><img src="img/wsw.jpg" width="155" height="19" alt=""/></div>
                                </div>
                            </div>
                            <div class="inputbox_input">
                                <textarea cols="2" rows="2" class="textarea_base" placeholder="Опишите шаг приготовления"></textarea>
                            </div>
                        </div>
                        <div class="add_steps_box_rasp"></div>
                        <div class="add_steps_box_right">
                            <div class="uploadbox_small">
                                <a href="#">
                                    <i class="fa fa-photo"></i>
                                    <span>Нажмите, чтобы <br />добавить фото</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="add_steps_bottom">
                        <a href="#" class="b_gray"><i class="fa fa-plus-circle"></i>Добавить еще один шаг</a>
                    </div>
                </div>
                <div class="p40"></div>
                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Хозяйке на заметку:</div>
                            <div class="inputbox_label_right"><img src="img/wsw.jpg" width="155" height="19" alt=""/></div>
                        </div>
                    </div>
                    <div class="inputbox_input">
                        <textarea cols="2" rows="2" class="textarea_base" placeholder="Напишите какой-нибудь совет, тем, кто будет готовить ваш рецепт"></textarea>
                    </div>
                </div>
                <div class="add_recipe_bottom">
                    <a href="#" class="b_red"><i class="fa fa-plus"></i>Добавить рецепт</a>
                </div>
            </form>
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
                    <input type="checkbox" id="filter_product_country8" name="filter_product_country8" value="8" class="checkbox">
                    <label id="filter_product_country_label8" for="filter_product_country8">
                        Получать комментарии к рецепту на почту
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
