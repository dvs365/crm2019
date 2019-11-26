<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_phone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_phone', // required: css class selector
    'widgetItem' => '.item_client_phone', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item_client_phone', // css class
    'deleteButton' => '.remove-item_client_phone', // css class
    'model' => $modelsClientPhone[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'number',
        'comment'
    ],
]); ?>
<table class="w100p container-items_client_phone">
    <?php foreach($modelsClientPhone as $index => $clientPhone):?>
    <tr class="item_client_phone">
        <td class="w180">Телефон</td>
        <td>
            <?php
            //necessary for update action.
            if(!$clientPhone->isNewRecord) {
                echo Html::activeHiddenInput($clientPhone, "[{$index}]id");
            }
            ?>
            <?= $form->field($clientPhone, "[{$index}]number", ['template' => "{error}{input}"])->textInput(['class' => 'phone_number', 'maxlength' => true,'placeholder' => '+7'])?>
            <?= $form->field($clientPhone, "[{$index}]comment", ['template' => "{input}"])->textInput(['class' => 'phone_comment', 'maxlength' => true,'placeholder' => 'Комментарий к телефону'])?>
            <div class="add-item_client_phone btn right">Добавить</div>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>