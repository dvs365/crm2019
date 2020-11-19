<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'formnote', 'action' => ['client/note', 'id' => $client->id], 'options' => ['class' => 'note'], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
<?=$form->field($client, 'note', ['template' => "{input}"])->textArea(['placeholder' => 'Заметка', 'class' => 'wrap3 autoheight', 'maxlength' => true]) ?>
<?=Html::submitInput('Добавить', ['class' => 'addnote btn right'])?>
<?=Html::tag('div', Html::tag('pre'), ['class' => 'fake_textarea'])?>
<?=Html::tag('div', '', ['class' => 'clear'])?>
<?php ActiveForm::end(); ?>