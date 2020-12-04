<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<div id="open-add-work" class="color_blue f128 wrap1">Добавить дело</div>
<div id="form-work" class="wrap1">
	<table class="w100p">
		<tr>
			<td class="w140 f128">Новое дело</td>
			<td>
<? $form = ActiveForm::begin(['action' => $action, 'method' => 'post']); ?>
	<?=$form->field($model, 'name', ['template' => "{input}"])->textInput(['placeholder' => 'Наименование дела', 'class' => 'wrap3 autoheight h36', 'maxlength' => true]) ?>
	<div class="fake_textarea h36"><pre></pre></div>
	<?=$form->field($model, 'description', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'class' => 'wrap3 autoheight', 'maxlength' => true]) ?>
	<div class="fake_textarea"><pre></pre></div>
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
	<table class="w100p wrap2">
		<?if (\Yii::$app->user->can('addTodoUser')):?>
		<tr>
			<td class="w65">
				Менеджер
			</td>
			<td class="user_name">
				<?$users = ArrayHelper::map($users, 'id', 'surnameNP')?>
				<?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($users, ['id' => 'todo-to-user', 'prompt' => ['text' => '', 'options' => ['value' => '0']]])?>
			</td>
		</tr>
		<?endif;?>
	</table>
	<?=$form->field($model, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__s color_blue', 'readonly' => true, 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this);', 'onKeyUp' => 'xCal();','maxlength' => true]) ?>
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
		<?=$form->field($model, 'dateto', ['template' => "До {input}"])->textInput(['class' => 'task_date__s color_blue', 'readonly' => '', 'onClick' => 'par={class:\'xcalend\', to:\'\'};xCal(this)', 'onKeyUp' => 'xCal()','maxlength' => true]) ?>
	</div>
	<input type="submit" class="btn right" value="Добавить">
<?php ActiveForm::end(); ?>
				<div class="clear"></div>
			</td>
		</tr>
	</table>
</div>