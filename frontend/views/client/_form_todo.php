<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $todo = new common\models\Todo;?>
<?php $form = ActiveForm::begin(['id' => 'formtodoclient', 'action' => ['todo/create', 'client' => $client->id], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
    <?=$form->field($todo, 'name', ['template' => "{input}"])->textInput(['placeholder' => 'Наименование дела', 'class' => 'wrap3', 'maxlength' => true]) ?>
    <?=$form->field($todo, 'description', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'id' => 'task-comment', 'class' => 'wrap3', 'maxlength' => true]) ?>
    <?=$form->field($todo, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__s color_blue', 'readonly' => '', 'onClick' => 'xCal(this);', 'onKeyUp' => 'xCal();','maxlength' => true]) ?>
    <div class="task_desc color_blue">Описание дела<div class="dropdown"></div></div>
    <div class="task_time">
        <?=$form->field($todo, 'time', ['template' => "в {input}"])->dropDownList([
                '08:00'=>'08:00',
                '09:00'=>'09:00',
                '10:00'=>'10:00',
                '11:00'=>'11:00',
                '12:00'=>'12:00',
                '13:00'=>'13:00',
                '14:00'=>'14:00',
                '15:00'=>'15:00',
                '16:00'=>'16:00',
                '17:00'=>'17:00',
                '18:00'=>'18:00'
        ], ['class' => 'color_blue', 'promt' => ''])?>
    </div>
    <div class="task_time">
        <?=$form->field($todo, 'dateto', ['template' => "До {input}"])->textInput(['class' => 'dateto task_date__s color_blue', 'readonly' => '', 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this)', 'onKeyUp' => 'xCal()','maxlength' => true]) ?>
    </div>
    <?=Html::submitInput('Добавить', ['class' => 'addtodo btn right'])?>
<?php ActiveForm::end(); ?>