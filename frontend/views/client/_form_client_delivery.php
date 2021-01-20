<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_delivery', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_delivery', // required: css class selector
    'widgetItem' => '.client_delivery_item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-address', // css class
    'deleteButton' => '.remove-item_client_mail', // css class
    'model' => $modelsDelivery[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'address',
    ],
]); ?>
<table class="container-items_client_delivery w100p wrap3-0">
    <?php foreach($modelsDelivery as $index => $clientDelivery):?>
    <tr class="client_delivery_item">
        <td></td>
        <td>
            <?php
            //necessary for update action.
            if(!$clientDelivery->isNewRecord) {
                echo Html::activeHiddenInput($clientDelivery, "[{$index}]id");
            }
            ?>
            <?= $form->field($clientDelivery, "[{$index}]address", ['template' => "{input}"])->textarea(['class' => 'client_add_delivery autoheight', 'maxlength' => true,'placeholder' => 'Индекс, страна, регион, город, улица, дом'])?>
			<?=Html::tag('div', Html::tag('pre'), ['class' => 'fake_textarea'])?>
			<?=Html::tag('div', 'Добавить', ['class' => 'btn right add-address'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>