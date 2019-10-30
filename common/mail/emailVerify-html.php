<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте <?= Html::encode($user->surname . ' '. $user->name . ' '. $user->patronymic) ?>,</p>
    <p>Временный пароль - <?= $pass?> будет доступен после перехода по ссылке:</p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
