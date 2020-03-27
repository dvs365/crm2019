<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<?php $form = ActiveForm::begin(['action' => ['client/transfer'], 'method' => 'get', 'options' => ['class' => 'filters wrap1', 'id' => 'searchclient']]); ?>
    <div class="wrap1 client_transfer_filters">
        <label class="wrap_quarter_manager">Менеджер:
            <div class="select">
                <div class="dropdown"></div>
                <?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
                <?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($managers, ['class' => '', 'prompt' => 'Все'])?>
            </div>
        </label>
        <?$status = $model->statusLabels;?>
        <?= $form->field($model, 'statuses', ['template' => "{input}"])->checkboxList($status, [
                'item' => function($index, $label, $name, $checked, $value){
                    $checked = $checked ? 'checked' : '';
                    return '<label class="wrap_quarter lh30">
                                <input type="checkbox" name="'.$name.'" value="'.$value.'" '.$checked.'>
                                <span class="checkbox"></span>
                                '.$label.'
                            </label>';
                }
        ])->label(false);?>
        <div class="clear"></div>
    </div>
    <?=$form->field($model, 'search', ['template' => "{input}"])->textInput(['id' => "search", 'placeholder' => 'Разделяйте варианты вертикальным слешем. Например, Иванов | 45-78-62'])?>
    <?=Html::submitInput('Найти', ['class' => "btn w160 right"])?>
    <div id="slash" class="btn w30 right">|</div>
    <div class="clear"></div>
<?php ActiveForm::end(); ?>