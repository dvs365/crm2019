<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<? $form = ActiveForm::begin(['action' => $action, 'method' => 'post', 'options' =>  ['class' => 'task_manager right']]); ?>
	<label>Менеджер:
		<span class="select">
			<span class="dropdown"></span>
                <?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
                <?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($managers, ['onchange'=>'this.form.submit()', 'class' => '', 'prompt' => ['text' => 'Свои', 'options' => ['value' => Yii::$app->user->identity->id]], 'options' => [$userID => ['selected' => true]]])?>
		</span>
	</label>
<?php ActiveForm::end(); ?>