<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrface', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-faces', // required: css class selector
    'widgetItem' => '.face-item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.client_item_add', // css class
    'deleteButton' => '.remove-face', // css class
    'model' => $modelsFace[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'fullname',
        'position'
    ],
]); ?>
<div class="container-faces">
    <?php foreach($modelsFace as $indexFace => $clientFace):?>
    <div class="face-item">
        <h2>Контактное лицо <span class="client_item_number"><?=$indexFace+1?></span></h2>
        <?php
        //necessary for update action.
        if(!$clientFace->isNewRecord) {
            echo Html::activeHiddenInput($clientFace, "[{$indexFace}]id");
        }
        ?>
        <table class="w100p">
            <tr>
                <td class="w180">
                    ФИО
                </td>
                <td>
                    <?= $form->field($clientFace, "[{$indexFace}]fullname", ['template' => "{input}"])->textInput(['maxlength' => true])?>
                </td>
            </tr>
            <tr>
                <td>
                    Должность
                </td>
                <td>
                    <?= $form->field($clientFace, "[{$indexFace}]position", ['template' => "{input}"])->textInput(['maxlength' => true])?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <?=$this->render('_form_client_face_phone', [
                    'form' => $form,
                    'indexFace' => $indexFace,
                    'modelsFacePhone' => $modelsFacePhone[$indexFace],
                ]);?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?=$this->render('_form_client_face_mail', [
                        'form' => $form,
                        'indexFace' => $indexFace,
                        'modelsFaceMail' => $modelsFaceMail[$indexFace],
                    ]);?>
                </td>
            </tr>
        </table>
    </div>
    <?php endforeach;?>
</div>
<div class="client_item_add color_blue">Добавить контактное лицо <div class="dropdown"></div></div>
<?php DynamicFormWidget::end(); ?>