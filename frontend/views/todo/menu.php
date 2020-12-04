<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        [
			'label' => 'Активные <span class="work_active_value">(<span>'.\Yii::$app->todo->cur().'</span>)</span>', 
			'url' => ['todo/index', 'status' => \common\models\Todo::OPEN],
		],
        [
			'label' => 'Просроченные'.' <span class="work_overdue_value">(<span>'.\Yii::$app->todo->last().'</span>)</span>', 
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