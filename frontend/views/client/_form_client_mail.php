<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_mail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_mail', // required: css class selector
    'widgetItem' => '.item_client_mail', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item_client_mail', // css class
    'deleteButton' => '.remove-item_client_mail', // css class
    'model' => $modelsClientMail[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'mail',
    ],
]); ?>
<table class="w100p container-items_client_mail">
    <?php foreach($modelsClientMail as $index => $clientMail):?>
    <tr class="item_client_mail">
        <td class="w180">E-mail</td>
        <td>
            <?php
            //necessary for update action.
            if(!$clientMail->isNewRecord) {
                echo Html::activeHiddenInput($clientMail, "[{$index}]id");
            }
            ?>
            <?= $form->field($clientMail, "[{$index}]mail", ['template' => "{input}"])->textInput(['class' => 'mail', 'maxlength' => true])?>
            <div class="add-item_client_mail btn right">Добавить</div>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>
