<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = 'Редактирование клиента';
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsClientPhone' => $modelsClientPhone,
    'modelsClientMail' => $modelsClientMail,
    'modelsClientFace' => $modelsClientFace,
    'modelsFacePhone' => $modelsFacePhone,
    'modelsFaceMail' => $modelsFaceMail,
    'modelsOrganization' => $modelsOrganization,
    'modelsUser' => $modelsUser,
]) ?>