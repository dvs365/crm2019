<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
?>




<main>
    <h1 class="wrap1"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options' =>  ['class' => 'login'], 'fieldConfig' => ['enableLabel' => false]]); ?>
        <p>Для восстановления пароля введите адрес электронной почты, к которой привязан аккаунт. На неё придёт код подтверждения для смены пароля</p>
        <table class="w100p">
            <tr>
                <td class="w180">E-mail</td>
                <td><?= $form->field($model, 'email', ['template' => "{input}"])->input('email',['class' => 'mb10', 'autofocus' => true]) ?></td>
            </tr>
            <tr>
                <td class="w180 lh30"></td>
                <td><?= Html::submitInput('Получить код', ['class' => 'btn right', 'name' => 'login']) ?></td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>
</main>
