<?php
return [
    'name' => 'На-Плите.ру',
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'queue',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
            'cache' => 'cache'
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            //'retries' => 1,
        ],
        'formatter' => [
            'dateFormat' => 'php: d.m.Y',
            'datetimeFormat' => 'php: d.m.Y H:i'
        ],
        'settings' => [
            'class' => 'core\components\Settings\SettingsManager',
        ],
        'photoSaver' => [
            'class' => 'core\components\PhotoSaver'
        ],
        'queue' => [
            'class' => yii\queue\redis\Queue::class,
            'as log' => yii\queue\LogBehavior::class,
        ],
    ],
];
