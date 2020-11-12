<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Потенциальные', 'url' => ['client/index', 'role' => \common\models\Client::TARGET]],
        ['label' => 'Рабочие', 'url' => ['client/index', 'role' => \common\models\Client::LOAD]],
        ['label' => 'Отказные', 'url' => ['client/index', 'role' => \common\models\Client::REJECT]],
    ],
    'options' => ['tag' => 'div', 'class' => 'control left'],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>