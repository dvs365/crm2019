<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'disconfirm') ?>

    <?php // echo $form->field($model, 'discomment') ?>

    <?php // echo $form->field($model, 'update') ?>

    <?php // echo $form->field($model, 'update_u') ?>

    <?php // echo $form->field($model, 'update_s') ?>

    <?php // echo $form->field($model, 'update_e') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
