<?php
use app\components\Menu\MenuActive;
?>
<?= MenuActive::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Добавить клиента', 'url' => ['client/create'], 'template' => '<a href="{url}" class="btn ml20">{label}</a>', 'visible' => \Yii::$app->user->can('addUpNewClient')],
        ['label' => 'Передать клиентов', 'url' => ['client/transfer'], 'template' => '<a href="{url}" class="btn">{label}</a>', 'visible' => Yii::$app->controller->route != 'client/transfer' && \Yii::$app->user->can('admin')],
		['label' => '', 'template' => '<div class="clear"></div>'],
    ],
    'options' => ['tag' => 'div', 'class' => 'control_btn'],
    'itemOptions' => ['tag' => false],
    'activeCssClass' => 'activerole',
]);
?>