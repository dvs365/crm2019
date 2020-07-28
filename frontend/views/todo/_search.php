<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['index', 'status' => $status], 'method' => 'get', 'options' => ['class' => 'filters wrap1', 'id' => 'searchclient']]); ?>
	<?=$form->field($model, 'search', ['template' => "{input}"])->textInput(['id' => "search", 'placeholder' => 'Разделяйте варианты вертикальным слешем. Например, Иванов | 45-78-62'])?>
	<?=Html::submitInput('Найти', ['class' => "btn w160 right"])?>
	<div id="slash" class="btn w30 right">|</div>
	<div class="clear"></div>
<?php ActiveForm::end(); ?>