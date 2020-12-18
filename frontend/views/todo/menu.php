<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        [
			'label' => 'Активные <span class="work_active_value" id="work_active_value">(<span>'.$todoCurCnt.'</span>)</span>', 
			'url' => ['todo/index', 'status' => \common\models\Todo::OPEN],
		],
        [
			'label' => 'Просроченные'.' <span class="work_overdue_value" id ="work_overdue_value">(<span>'.$todoLateCnt.'</span>)</span>', 
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
<script>
	document.getElementById("work_value").textContent="(<?=$todoCurCnt+$todoLateCnt?>)";
</script>