<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_face_phone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_face_phone', // required: css class selector
    'widgetItem' => '.item_client_face_phone', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item_client_phone', // css class
    'deleteButton' => '.remove-item_client_face', // css class
    'model' => $modelsFacePhone[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'number',
        'comment',
    ],
]); ?>
<table class="w100p container-items_client_face_phone">
<?php foreach($modelsFacePhone as $indexPhone => $facePhone):?>
<tr class="item_client_face_phone">
    <td class="w180"></td>
    <td>
        <?php
        //necessary for update action.
        if(!$facePhone->isNewRecord) {
            echo Html::activeHiddenInput($facePhone, "[{$indexFace}][{$indexPhone}]id");
        }
        ?>
        <?= $form->field($facePhone, "[{$indexFace}][{$indexPhone}]number", ['template' => "{input}"])->textInput(['class' => 'phone_number', 'maxlength' => true,'placeholder' => '+7'])?>
        <?= $form->field($facePhone, "[{$indexFace}][{$indexPhone}]comment", ['template' => "{input}"])->textInput(['class' => 'phone_comment', 'maxlength' => true,'placeholder' => 'Комментарий к телефону'])?>
        <div class="btn right add-item_client_phone">Добавить</div>
        <div class="clear"></div>
    </td>
</tr>
<?php endforeach;?>
</table>
<?php DynamicFormWidget::end(); ?>