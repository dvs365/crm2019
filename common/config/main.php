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
		'session' => [
			'class' => 'yii\web\DbSession',
			'writeCallback' => function($session){
				return [
					'user_id' => Yii::$app->user->id
				];
			}
			// 'db' => 'mydb',  // the application component ID of the DB connection. Defaults to 'db'.
			// 'sessionTable' => 'my_session', // session table name. Defaults to 'session'.
		],
		
    ],
];
