<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<?php $form = ActiveForm::begin(['action' => ['index', 'sort' => $sort, 'role' => $role], 'method' => 'get', 'options' => ['class' => 'filters wrap1', 'id' => 'searchclient']]); ?>
    <div class="wrap1">
        <?if (\Yii::$app->user->can('admin')):?>
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
            <?=$form->field($model, 'task', ['template' => "<label class=\"lh30\">{input}<span class=\"checkbox\"></span> С активными делами</label>"])->checkbox([], false)?>
            <?=$form->field($model, 'disconfirm', ['template' => "<label class=\"lh30\">{input}<span class=\"checkbox\"></span> С несогласованной скидкой</label>"])->checkbox([], false)?>
        </div>
        <div class="clear"></div>
        <?endif;?>
    </div>
    <?=$form->field($model, 'search', ['template' => "{input}"])->textInput(['id' => "search", 'placeholder' => 'Разделяйте варианты вертикальным слешем. Например, Иванов | 45-78-62'])?>
    <?=Html::submitInput('Найти', ['class' => "btn w160 right"])?>
    <div id="slash" class="btn w30 right">|</div>
    <div class="clear"></div>
<?php ActiveForm::end(); ?>