<?php
use app\components\Menu\MenuActive;
?>

<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Свои', 'url' => ['set/profile']],
        ['label' => 'Пользователи', 'url' => ['set/users']],
        ['label' => 'Товары', 'url' => ['set/goods']],
    ],
    'options' => ['tag' => false],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>