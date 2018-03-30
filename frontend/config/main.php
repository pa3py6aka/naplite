<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'На-Плите',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'common\bootstrap\SetUp'],
    'controllerNamespace' => 'frontend\controllers',
    //'homeUrl' => ['/main/index'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
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
            'loginUrl' => ['main/index', 'login' => 1],
        ],
        'session' => [
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
                    'except' => ['yii\web\HttpException:404'],

                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'basePath' => '@webroot/bootstrap',
                    'baseUrl' => '@web/bootstrap',
                    'css' => ['css/bootstrap.css'],
                ],
            ],//*/
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('frontendUrlManager');
        },
    ],
    'on beforeRequest' => function () {
        $pathInfo = Yii::$app->request->pathInfo;
        $query = Yii::$app->request->queryString;
        if (!empty($pathInfo) && substr($pathInfo, -1) === '/') {
            $url = '/' . substr($pathInfo, 0, -1);
            if ($query) {
                $url .= '?' . $query;
            }
            Yii::$app->response->redirect($url, 301)->send();
            Yii::$app->end();
        }
    },
    'params' => $params,
];
