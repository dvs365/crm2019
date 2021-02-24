<?php
use app\components\Menu\MenuActive;
?>

<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Свои', 'url' => ['profile/index']],
        ['label' => 'Пользователи', 'url' => ['user/index']],
        ['label' => 'Товары', 'url' => ['product/index']],
		['label' => 'Дополнительно', 'url' => ['add/index']],
    ],
    'options' => ['tag' => false],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>