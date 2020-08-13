<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;

$this->title = 'Добавление пользователя';
?>
<main>
    <div class="wrap1 control">
        <?=$this->render('/set/_menu')?>
    </div>
    <h1 class="wrap1"><?= Html::encode($this->title) ?></h1>
	<?=$this->render('_form', [
		'model' => $model,
	])?>
</main>