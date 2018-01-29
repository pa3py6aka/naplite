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
                <div id="weightsSearchContent"></div>
            </div>
        </div>
    </div>
</div>
