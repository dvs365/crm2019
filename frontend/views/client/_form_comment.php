<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $comment = new common\models\Comment;?>
<?php $form = ActiveForm::begin(['id' => 'formcomment', 'action' => ['comment/create', 'client' => $client->id], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
<?=$form->field($comment, 'text', ['template' => "{input}"])->textArea(['placeholder' => 'Новый комментарий', 'class' => 'wrap3', 'maxlength' => true]) ?>
<?=Html::submitInput('Добавить', ['class' => 'addcomment btn right'])?>
<?php ActiveForm::end(); ?>