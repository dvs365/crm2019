<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_face_mail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_face_mail', // required: css class selector
    'widgetItem' => '.item_client_face_mail', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item_client_mail', // css class
    'deleteButton' => '.remove-item_client_face', // css class
    'model' => $modelsFaceMail[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'mail',
    ],
]); ?>
<table class="w100p container-items_client_face_mail">
<?php foreach($modelsFaceMail as $indexMail => $faceMail):?>
    <tr class="item_client_face_mail">
        <td class="w180"></td>
        <td>
            <?php
            //necessary for update action.
            if(!$faceMail->isNewRecord) {
                echo Html::activeHiddenInput($faceMail, "[{$indexFace}][{$indexMail}]id");
            }
            ?>
            <?= $form->field($faceMail, "[{$indexFace}][{$indexMail}]mail", ['template' => "{input}"])->textInput(['class' => 'mail', 'maxlength' => true])?>
            <div class="btn right add-item_client_mail">Добавить</div>
            <div class="clear"></div>
        </td>
    </tr>
<?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>
