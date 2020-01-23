<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrfphone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-fphones', // required: css class selector
    'widgetItem' => '.fphone-item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-fphone', // css class
    'deleteButton' => '.remove-fphone', // css class
    'model' => $modelsFacePhone[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'number',
        'comment',
    ],
]); ?>
<table class="w100p">
    <tbody class="container-fphones">
        <?php foreach($modelsFacePhone as $indexPhone => $facePhone):?>
        <tr class="fphone-item">
            <td class="w180"><?=(!$indexPhone)?$facePhone->getAttributeLabel('number'):''?></td>
            <td>
                <?php
                //necessary for update action.
                if(!$facePhone->isNewRecord) {
                    echo Html::activeHiddenInput($facePhone, "[{$indexFace}][{$indexPhone}]id");
                }
                ?>
                <?= $form->field($facePhone, "[{$indexFace}][{$indexPhone}]number", ['template' => "{input}"])->textInput(['class' => 'phone_number', 'maxlength' => true,'placeholder' => '+7'])?>
                <?= $form->field($facePhone, "[{$indexFace}][{$indexPhone}]comment", ['template' => "{input}"])->textInput(['class' => 'phone_comment', 'maxlength' => true,'placeholder' => 'Комментарий к телефону'])?>
                <div class="add-fphone btn right">Добавить</div>
                <div class="clear"></div>
            </td>
        </tr>
        <?php endforeach;?>
        <?$flag = '222';?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>