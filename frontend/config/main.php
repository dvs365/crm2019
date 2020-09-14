<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
	'timeZone' => 'UTC',
	'homeUrl' => '/',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
			'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['js/jquery-2.2.4.js'],
                ]
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
			'defaultTimeZone' => 'UTC',
			'timeZone' => 'Europe/Samara',
            'dateFormat' => 'dd.MM.yyyy',
            'timeFormat' => 'HH:mm',
            'decimalSeparator' => ' ',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				'<controller:\w+>' => '<controller>/index',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',			
            ],
        ],
    ],
    'modules' => [
      'gii' => [
          'class' => 'yii\debug\Module',
          'allowedIPs' => ['*'],
      ]
    ],
    'params' => $params,
];
