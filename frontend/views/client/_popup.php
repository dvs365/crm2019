<?
use yii\bootstrap\Modal;

Modal::begin([
	'headerOptions' => [
		'style' => 'display:none;',
	],
	'footerOptions' => [
		'style' => 'display:none;',
	],	
	'header' => '<h2>Клиенты переданны.</h2>',
	'footer' => '',
	'clientOptions' => [
		'show' => true,
		],
	]);

echo '<h2 style="text-align: center;">Клиенты переданны.</h2><br><p style="text-align: center;">Передача клиентов прошла успешно.</p>';

Modal::end();

