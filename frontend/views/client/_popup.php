<?
use yii\bootstrap\Modal;

Modal::begin([
	'header' => '<h2>Клиенты переданны.</h2>',
	'footer' => '',
	'clientOptions' => [
		'show' => true,
		],
	]);

echo 'Передача клиентов прошла успешно.';

Modal::end();

