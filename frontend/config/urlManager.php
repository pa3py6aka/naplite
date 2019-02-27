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
        '<_a:contact>' => 'site/<_a>',
        '<_c:category|collections>/<slug:[a-z0-9_-]+>' => '<_c>/view',

        '<_c:articles|ingredients>/category/<category:[a-z0-9_-]+>' => '<_c>/index',
        '<_c:articles|kitchens>/<slug:[a-z0-9_-]+>' => '<_c>/view',

        'recipes/<_a:new|rate|save-to-user|print|upload|get-sub-categories|crop>' => 'recipes/<_a>',
        'recipes/<slug:[a-z0-9_-]+>' => 'recipes/view',
        'recipes/<slug:[a-z0-9_-]+>/<_a:edit|remove>' => 'recipes/<_a>',
        'recipes' => 'category/view',

        // Не забудьте добавить нужные экшены(доступные по адресу /forum/<action>) в core\helpers\BlogHelper::USED_ACTIONS
        'forum/create' => 'blog/create',
        'forum/<category:[a-z0-9_-]+>' => 'blog/index',
        'forum' => 'blog/index',
        'forum/<category:[a-z0-9_-]+>/<post:[a-z0-9_-]+>' => 'blog/view',
        'forum/<category:[a-z0-9_-]+>/<post:[a-z0-9_-]+>/edit' => 'blog/edit',

        'id<id:\d+>' => 'users/view',
        'id<id:\d+>/<_a:recipes|cookbook|posts|photos>/<category:[a-z0-9_-]+>' => 'users/<_a>',
        'id<id:\d+>/<_a:recipes|cookbook|posts|photos>' => 'users/<_a>',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];