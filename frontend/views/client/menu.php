<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Потенциальные', 'url' => ['client/index', 'role' => \common\models\Client::TARGET]],
        ['label' => 'Рабочие', 'url' => ['client/index', 'role' => \common\models\Client::LOAD]],
        ['label' => 'Отказные', 'url' => ['client/index', 'role' => \common\models\Client::REJECT]],
        ['label' => 'Добавить клиента', 'url' => ['client/create'], 'template' => '<a href="{url}" class="btn w160 right ml20">{label}</a>', 'visible' => \Yii::$app->user->can('addUpNewClient')],
        ['label' => 'Передать клиентов', 'url' => ['client/transfer'], 'template' => '<a href="{url}" class="btn w160 right">{label}</a>', 'visible' => Yii::$app->controller->route != 'client/transfer' && \Yii::$app->user->can('admin')],
    ],
    'options' => ['tag' => false],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>