<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <h1 class="wrap1"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' =>  ['class' => 'login'], 'fieldConfig' => ['enableLabel' => false]]); ?>
    <span class="error color_red"><?= Html::errorSummary($model, ['header' => ''])?></span>
    <p>Пароль должен состоять как минимум из восьми символов, среди которых как минимум одна заглавная буква, одна строчная буква, одна цифра и один символ</p>
    <table class="w100p">
        <tr>
            <td class="w180 lh-cancel418">Новый пароль</td>
            <td><?= $form->field($model, 'password', ['template' => "{input}"])->passwordInput(['autofocus' => true, 'class' => 'mb10']) ?></td>
        </tr>
        <tr>
            <td class="w180 lh-cancel418">Повторите пароль</td>
            <td><?= $form->field($model, 'passwordr', ['template' => "{input}"])->passwordInput(['autofocus' => true, 'class' => 'mb10']) ?></td>
        </tr>
        <tr>
            <td class="w180"></td>
            <td><?= Html::submitInput('Сохранить', ['class' => 'btn right']) ?></td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
</main>
