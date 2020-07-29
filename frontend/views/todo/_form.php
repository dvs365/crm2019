<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<div id="open-add-work" class="color_blue f128 wrap1">Добавить дело</div>
<div id="form-work" class="wrap1">
	<table class="w100p">
		<tr>
			<td class="w120 f128">Новое дело</td>
			<td>
<? $form = ActiveForm::begin(['action' => $action, 'method' => 'post']); ?>
	<?=$form->field($model, 'name', ['template' => "{input}"])->textInput(['placeholder' => 'Наименование дела', 'class' => 'wrap3', 'maxlength' => true]) ?>
	<?=$form->field($model, 'description', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'class' => 'wrap3', 'maxlength' => true]) ?>
	<table class="w100p wrap2">
		<tr>
			<td class="w65">
				Клиент
			</td>
			<td class="client_name">
				<?$client = ArrayHelper::map($clients, 'id', 'name')?>
				<?=$form->field($model, 'client', ['template' => "{input}"])->dropDownList($client, ['class' => 'searchselect', 'prompt' => ['text' => '', 'options' => ['value' => '0']]])?>
			</td>
		</tr>
	</table>
	<?=$form->field($model, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__s color_blue', 'readonly' => true, 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this);', 'onKeyUp' => 'xCal();','maxlength' => true]) ?>
    <div class="task_time__visible">
        <?=$form->field($model, 'time', ['template' => "в {input}"])->dropDownList([
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
	<div class="left">
		<?=$form->field($model, 'dateto', ['template' => "До {input}"])->textInput(['class' => 'task_date__s color_blue', 'readonly' => '', 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this)', 'onKeyUp' => 'xCal()','maxlength' => true]) ?>
	</div>
	<input type="submit" class="btn right" value="Добавить">
<?php ActiveForm::end(); ?>
				<div class="clear"></div>
			</td>
		</tr>
	</table>
</div>