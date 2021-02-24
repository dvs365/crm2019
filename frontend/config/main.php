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

				'<module:[\w-]+>/' => '<module>/default/index',
				'<module:[\w-]+>/<controller:[\w-]+>' => '<module>/<controller>/index',
				'<module:[\w-]+>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/view',
				'<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>', 
				'<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>', 
				
            ],
        ],
		'mark' => [
            'class' => 'frontend\components\Mark',
        ],
		'todo' => [
			'class' => 'frontend\components\TodoCnt',
		],
    ],
    'modules' => [
		'gii' => [
			'class' => 'yii\debug\Module',
			'allowedIPs' => ['*'],
      ],
		'setup' => [
			'class' => 'frontend\modules\setup\Module',
		],
    ],
    'params' => $params,
];
