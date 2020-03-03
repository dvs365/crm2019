<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'formnote', 'action' => ['client/note', 'id' => $client->id], 'options' => ['class' => 'note'], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
<?=$form->field($client, 'note', ['template' => "{input}"])->textArea(['placeholder' => 'Заметка', 'class' => 'wrap3', 'maxlength' => true]) ?>
<?=Html::submitInput('Добавить', ['class' => 'addnote btn right'])?>
<div class="clear"></div>
<?php ActiveForm::end(); ?>