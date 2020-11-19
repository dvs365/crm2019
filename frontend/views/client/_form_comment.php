<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<? $comment = new common\models\Comment;?>
<? $form = ActiveForm::begin(['id' => 'formcomment', 'action' => ['comment/create', 'client' => $client->id], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false, 'options' => ['class' => 'wrap1']]); ?>
<?=$form->field($comment, 'text', ['template' => "{input}"])->textArea(['placeholder' => 'Новый комментарий', 'class' => 'wrap3 autoheight', 'maxlength' => true]) ?>
<?=Html::tag('div', Html::tag('pre'), ['class' => 'fake_textarea'])?>
<?=Html::submitInput('Добавить', ['class' => 'addcomment btn right'])?>
<?=Html::tag('div','',['class' => 'comment_date'])?>
<?=Html::tag('div','',['class' => 'clear'])?>
<? ActiveForm::end(); ?>