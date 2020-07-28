<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        [
			'label' => 'Активные', 
			'url' => ['todo/index', 'status' => \common\models\Todo::OPEN],
		],
        [
			'label' => 'Просроченные', 
			'url' => ['todo/index', 'status' => \common\models\Todo::LATE],
		],
        [
			'label' => 'Закрытые', 
			'url' => ['todo/index', 'status' => \common\models\Todo::CLOSE],
		],
    ],
    'options' => ['tag' => false],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>