<?php
return [
    'language' => 'ru-RU',
    'name' => 'Сансфера - система управления',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'cache' => 'cache'
        ],
    ],
];
