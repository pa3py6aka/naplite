<?php
use yii\helpers\Url;
?>
<span class="socials_icons">
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'fb']) ?>"><img src="/img/ico_facebook.png" width="35" height="35" alt=""/></a>
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'vk']) ?>"><img src="/img/ico_vk.png" width="35" height="35" alt=""/></a>
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'tw']) ?>"><img src="/img/ico_twitter.png" width="35" height="35" alt=""/></a>
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'od']) ?>"><img src="/img/ico_od.png" width="35" height="35" alt=""/></a>
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'ya']) ?>"><img src="/img/ico_yandex.png" width="35" height="35" alt=""/></a>
    <a href="<?= Url::to(['/network/auth', 'authclient' => 'google']) ?>"><img src="/img/ico_google.png" width="35" height="35" alt=""/></a>
</span>