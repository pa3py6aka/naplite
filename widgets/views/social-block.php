<?php
/* @var */

?>
<div class="socials_plugin">
    <div class="socials_tabs">
        <a href="javascript:void(0)" class="socials_tabs_active" data-sn="vk">Вконтакте</a>
        <a href="javascript:void(0)" data-sn="inst">Instagram</a>
        <a href="javascript:void(0)" data-sn="fb">Facebook</a>
    </div>
    <div class="socials_content" id="vk_groups" data-sn="vk">
        <script type="text/javascript">
            <?= Yii::$app->settings->get('widgetVK') ?>
        </script>
    </div>
    <div class="socials_content" data-sn="inst" style="display:none;position: relative;">
        <div>
            <iframe src='/inwidget/index.php?toolbar=false&inline=3' data-inwidget scrolling='no' frameborder='no' style='border:none;width:100%;height:246px;overflow:hidden;'></iframe>
        </div>
    </div>
    <div class="socials_content" data-sn="fb" style="display:none;">
        <?= Yii::$app->settings->get('widgetFB') ?>
    </div>
</div>
<div class="p40"></div>
