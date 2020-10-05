<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<? $form = ActiveForm::begin(['action' => $action, 'method' => 'post']); ?>
	<?=$form->field($model, 'name', ['template' => "{input}"])->textInput(['placeholder' => 'Наименование дела', 'class' => 'wrap3', 'maxlength' => true]) ?>
	<?=$form->field($model, 'description', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'class' => 'wrap3', 'maxlength' => true]) ?>
	<table class="w100p wrap2">
		<tr>
			<td>
				Клиент
			</td>
			<td class="client_name">
			<?//$client = ArrayHelper::map($clients, 'id', 'name')?>
			<?//=$form->field($model, 'client', ['template' => "{input}"])->dropDownList($client, ['class' => 'searchselect', 'prompt' => ['text' => "...", 'options' => ['value' => '0']]])?>
			<?=($model->client0)?$model->client0->name:''?>
			</td>
		</tr>
	</table>
	<?$model->time = date('H:i',strtotime($model->date))?>
	<?$model->date = date('d.m.Y',strtotime($model->date))?>
	<?=$form->field($model, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__r color_blue', 'readonly' => true, 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this);', 'onKeyUp' => 'xCal();','maxlength' => true]) ?>
    <div class="task_time__visible">
        <?=$form->field($model, 'time', ['template' => "в {input}"])->dropDownList([
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
	<div class="left">
		<?$model->dateto = date('d.m.Y',strtotime($model->dateto))?>
		<?=$form->field($model, 'dateto', ['template' => "До {input}"])->textInput(['class' => 'task_date__r color_blue', 'readonly' => '', 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this)', 'onKeyUp' => 'xCal()','maxlength' => true]) ?>
	</div>
	<input type="submit" class="btn right" value="Изменить">
<?php ActiveForm::end(); ?>