<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['action' => ['index', 'role' => $role], 'method' => 'get', 'options' => ['class' => 'filters wrap1', 'id' => 'searchclient']]); ?>
    <div class="wrap1">
        <div class="wrap_half" id="lefthalf">
            <label>Обращение за <?=$form->field($model, 'permonth', ['template' => "{input}"])->input('number') ?> мес.</label>
            <label>Менеджер:
                <div class="select">
                    <div class="dropdown"></div>
                    <?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
                    <?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($managers, ['class' => '', 'prompt' => 'Все'])?>
                </div>
            </label>
        </div>
        <div class="wrap_half">
            <label class="lh30">
                <?=$form->field($model, 'task', ['template' => "{input}"])->checkbox([], false)?>
                <span class="checkbox"></span>
                С активными делами
            </label>
            <label class="lh30">
                <?=$form->field($model, 'disconfirm', ['template' => "{input}"])->checkbox([], false)?>
                <span class="checkbox"></span>
                С несогласованной скидкой
            </label>
        </div>

        <div class="clear"></div>
    </div>
    <?=$form->field($model, 'search', ['template' => "{input}"])->textInput(['id' => "search", 'placeholder' => 'Разделяйте варианты вертикальным слешем. Например, Иванов | 45-78-62'])?>
    <?=Html::submitInput('Найти', ['class' => "btn w160 right"])?>
    <div id="slash" class="btn w30 right">|</div>
    <div class="clear"></div>
<?php ActiveForm::end(); ?>