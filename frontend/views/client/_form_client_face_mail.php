<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrfmail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-fmails', // required: css class selector
    'widgetItem' => '.fmail-item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-fmail', // css class
    'deleteButton' => '.remove-item_client_face', // css class
    'model' => $modelsFaceMail[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'mail',
		'comment',
    ],
]); ?>
<table class="w100p">
    <tbody class="container-fmails">
        <?php foreach($modelsFaceMail as $indexMail => $faceMail):?>
            <tr class="fmail-item">
                <td class="w180 fmail"><?=(!$indexMail)?$faceMail->getAttributeLabel('mail'):''?></td>
                <td>
                    <?php
                    //necessary for update action.
                    if(!$faceMail->isNewRecord) {
                        echo Html::activeHiddenInput($faceMail, "[{$indexFace}][{$indexMail}]id");
                    }
                    ?>
                    <?= $form->field($faceMail, "[{$indexFace}][{$indexMail}]mail", ['template' => "{error}{input}"])
					->input('email', ['class' => 'mail', 'maxlength' => true])?>
					<?= $form->field($faceMail, "[{$indexFace}][{$indexMail}]comment", ['template' => "{error}{input}"])
					->textInput(['class' => 'mail_comment', 'placeholder' => 'Комментарий к e-mail', 'maxlength' => true])?>					
                    <div class="add-fmail btn right">Добавить</div>
                    <div class="clear"></div>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
