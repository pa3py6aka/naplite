<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Панель Управления',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'common\bootstrap\SetUp'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => 'core\components\YiiUser',
            'identityClass' => 'core\entities\User\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => $params['cookieDomain'],
            ],
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => '_session',
            'cookieParams' => [
                'domain' => $params['cookieDomain'],
                'httpOnly' => true,
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('backendUrlManager');
        },
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['site/login', 'site/error', 'site/logout'],
        'rules' => [
            [
                'allow' => true,
                'roles' => [\core\access\Rbac::ROLE_MODERATOR],
            ],
        ],
    ],
    'params' => $params,
];
