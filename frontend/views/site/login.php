<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<main>
    <h1 class="wrap1">Вход в систему</h1>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' =>  ['class' => 'login'], 'fieldConfig' => ['enableLabel' => false]]); ?>
        <table class="w100p">
            <tr>
                <td class="w180">E-mail</td>
                <td><?= $form->field($model, 'email', ['template' => "{input}"])->input('email', ['class' => 'mb10', 'autofocus' => true]) ?></td>
            </tr>
            <tr>
                <td class="w180">Пароль</td>
                <td><?= $form->field($model, 'password', ['template' => "{input}"])->input('password', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180 lh30 lh-cancel418"><?= Html::a('Восстановить пароль', ['site/request-password-reset']) ?></td>
                <td><?= Html::submitInput('Войти', ['class' => 'btn right', 'name' => 'login']) ?></td>
            </tr>
            <?= ($model->errors)? '<p class="color_red">Неправильно введён логин либо пароль</p>' : ''?>
            <!--<br>
            Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>-->
        </table>
    <?php ActiveForm::end(); ?>
</main>
