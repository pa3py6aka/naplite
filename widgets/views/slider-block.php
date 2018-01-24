<?php
/* @var $items array */

use widgets\CarouselNaPlite;

?>
<li class="top_articles">
    <?= CarouselNaPlite::widget([
        'items' => $items,
        'options' => ['class' => 'slider-block slide', 'data-interval' => '12000'],
        'showIndicators' => false,
        'controls' => [
            '<i class="fa fa-arrow-circle-left"></i><span></span>',
            '<i class="fa fa-arrow-circle-right"></i><span></span>'
        ]
    ]); ?>
</li>

<script type="text/javascript">
    window.addEventListener('load', function (e) {
        $('.slider-block').on('slid.bs.carousel', function (e) {
            var n = $('.slider-block .item.active').index('.slider-block .item') + 1;
            $('.top_articles_box_arrows_center').text('<?= count($items) ?>/' + n);
        });
    });
</script>
