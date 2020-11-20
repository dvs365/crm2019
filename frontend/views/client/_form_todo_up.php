<?php
use yii\helpers\Html;
use yii\helpers\Button;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'formtodoclientup', 'action' => ['todo/update', 'id' => $todo->id], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false, 'options' => ['class' => 'task_change']]); ?>
    <span>
		<?=$form->field($todo, 'name', ['template' => "{input}"])->textInput(['placeholder' => 'Наименование дела', 'class' => 'wrap3 autoheight h36', 'maxlength' => true]) ?>
		<?=Html::tag('div', $todo->name ?: Html::tag('pre'), ['class' => 'fake_textarea h36'])?>
	</span>
	<span>
		<?=$form->field($todo, 'description', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'class' => 'wrap3 autoheight', 'maxlength' => true]) ?>
		<?=Html::tag('div', $todo->description ?: Html::tag('pre'), ['class' => 'fake_textarea h36'])?>
	</span>
	<?$todo->time = date('H:i',strtotime($todo->date))?>
	<?$todo->date = date('d.m.Y',strtotime($todo->date))?>
	<?=$form->field($todo, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__r color_blue', 'readonly' => true, 'onClick' => 'xCal(this);', 'onKeyUp' => 'xCal();','maxlength' => true]) ?>
    <div class="task_time__visible">
        <?=$form->field($todo, 'time', ['template' => "в {input}"])->dropDownList([
                '01:00'=>'01:00',
                '02:00'=>'02:00',
                '03:00'=>'03:00',
                '04:00'=>'04:00',
                '05:00'=>'05:00',
                '06:00'=>'06:00',
                '07:00'=>'07:00',
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
                '18:00'=>'18:00',
                '19:00'=>'19:00',
                '20:00'=>'20:00',
                '21:00'=>'21:00',
                '22:00'=>'22:00',
                '23:00'=>'23:00'
        ], ['class' => 'color_blue', 'promt' => ''])?>
    </div>
    <div class="task_time__visible">
		<?$todo->dateto = date('d.m.Y',strtotime($todo->dateto))?>
        <?=$form->field($todo, 'dateto', ['template' => "До {input}"])->textInput(['class' => 'dateto task_date__r color_blue', 'readonly' => '', 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this)', 'onKeyUp' => 'xCal()','maxlength' => true]) ?>
	</div>
	<?//=Html::submitButton(['Button', 'options' => ['class' => 'addtodo btn right', 'onClick' => 'alert("Button 1 clicked");']])?>
    <?=Html::submitInput('Изменить', ['class' => 'addtodo btn right', 'onclick' => 'changeTask(this);'])?>
	<div class="clear"></div>
<?php ActiveForm::end(); ?>