<?php
use frontend\assets\ClientAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
ClientAsset::register($this);
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
	'modelsDelivery' => $modelsDelivery,
    'modelsUser' => $modelsUser,
]) ?>