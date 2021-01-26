<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_mail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_mail', // required: css class selector
    'widgetItem' => '.item_client_mail', // required: css class
    'limit' => 30, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-cmail', // css class
    'deleteButton' => '.remove-cmail', // css class
    'model' => $modelsClientMail[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'mail',
		'comment',
    ],
]); ?>
<table class="w100p container-items_client_mail">
    <?php foreach($modelsClientMail as $index => $clientMail):?>
    <tr class="item_client_mail">
        <td class="w180"></td>
        <td>
            <?php
            //necessary for update action.
            if(!$clientMail->isNewRecord) {
                echo Html::activeHiddenInput($clientMail, "[{$index}]id");
            }
            ?>
            <?= $form->field($clientMail, "[{$index}]mail", ['template' => "{error}{input}"])
			->input('email', ['class' => 'mail', 'maxlength' => true])?>
			<?= $form->field($clientMail, "[{$index}]comment", ['template' => "{error}{input}"])
			->textInput(['class' => 'mail_comment', 'placeholder' => 'Комментарий к e-mail', 'maxlength' => true])?>
			<div class="add-cmail btn right">Добавить</div>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>
