<?
use yii\widgets\ActiveForm;
?>

<? $form = ActiveForm::begin(['action' => $action, 'method' => 'post', 'options' =>  ['id' => 'choise-date']]); ?>
	<h1>Активные дела на 
	<label class="date_a">
	<?=$form->field($model, 'date', ['template' => "{input}"])->textInput(['class' => 'task_date__s w0', 'readonly' => true, 'onClick' => 'par={class:\'xcalend2\', to:\'choise-date\'};xCal(this);'])?>
	<span class="color_blue"></span></label> года</h1>
	<?php ActiveForm::end(); ?>