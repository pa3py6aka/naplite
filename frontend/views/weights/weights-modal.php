<?php
/* @var  */

use yii\helpers\Html;

?>
<div class="modalbox" id="weightsModal">
    <div class="modal_outer">
        <div class="modal_inner modal_inner_iphone">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="fixed">
                    <h1>Таблица мер и весов</h1>
                    <div class="th_search">
                        <?= Html::beginForm(['/weights/load'], 'post', ['id' => 'weightsSearchForm']) ?>
                            <div class="top_bottom_center_inner">
                                <div class="top_bottom_center_inner_left">
                                    <input type="text" name="search" placeholder="Введите название продукта..." />
                                </div>
                                <div class="top_bottom_center_inner_right">
                                    <a href="javascript:void(0)" data-link="weights-search-link">
                                        <i class="fa fa-search"></i><span class="hidden740">Найти</span>
                                    </a>
                                </div>
                            </div>
                       <?= Html::endForm() ?>
                    </div>
                </div>
                <div id="weightsSearchContent">
                    <!--<div class="adaptive_table_measures">
                        <div class="adaptive_table_measures_name">Арахис молотый</div>
                        <table class="adaptive_table_measures_quantity">
                            <tr class="dark">
                                <td class="adaptive_table_measures_quantity_left">Стакан 250г:</td>
                                <td>155г</td>
                            </tr>
                            <tr>
                                <td class="adaptive_table_measures_quantity_left">Стакан 200г:</td>
                                <td>25г</td>
                            </tr>
                            <tr class="dark">
                                <td class="adaptive_table_measures_quantity_left">Ст.ложка:</td>
                                <td>23г</td>
                            </tr>
                            <tr>
                                <td class="adaptive_table_measures_quantity_left">Ч.ложка:</td>
                                <td>15г</td>
                            </tr>
                            <tr class="dark">
                                <td class="adaptive_table_measures_quantity_left">1 шт:</td>
                                <td>&mdash;</td>
                            </tr>
                        </table>
                    </div>
                    <table class="table_base hidden740">
                    <tr>
                        <th>Название</th>
                        <th>Стакан<br />250г</th>
                        <th>Стакан<br />200г</th>
                        <th>Столовая<br />ложка</th>
                        <th>Чайная<br />ложка</th>
                        <th>1 шт</th>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                    <tr class="dark">
                        <td>Арахи очищенный</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td>25</td>
                        <td></td>
                    </tr>
                </table>-->
                </div>
            </div>
        </div>
    </div>
</div>
