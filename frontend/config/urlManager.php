<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'main/index',
        '<_a:signup|login|logout>' => 'auth/<_a>',
        '<_c:category|collections>/<slug:[a-z0-9_-]+>' => '<_c>/view',

        '<_c:articles|ingredients>/category/<category:[a-z0-9_-]+>' => '<_c>/index',
        '<_c:articles>/<slug:[a-z0-9_-]+>' => '<_c>/view',

        // Не забудьте добавить нужные экшены(доступные по адресу /forum/<action>) в core\helpers\BlogHelper::USED_ACTIONS
        'forum/create' => 'blog/create',
        'forum/<category:[a-z0-9_-]+>' => 'blog/index',
        'forum' => 'blog/index',
        'forum/<category:[a-z0-9_-]+>/<post:[a-z0-9_-]+>' => 'blog/view',
        'forum/<category:[a-z0-9_-]+>/<post:[a-z0-9_-]+>/edit' => 'blog/edit',

        'id<id:\d+>' => 'users/view',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];