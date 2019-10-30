<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <? if(Yii::$app->user->isGuest){?>
        <header ID="header" class="wrap1">
            <div class="header">
                <span>Сансфера - система управления</span>
            </div>
        </header>
        <?=$content;?>
    <?}else{?>
        <header ID="header" class="wrap1">
            <nav>
                <?= Menu::widget([
                    'encodeLabels' => false,
                    'items' => [
                        ['label' => 'Сводка', 'url' => ['summary/index']],
                        ['label' => 'Клиенты', 'url' => ['client/index']],
                        ['label' => 'Дела', 'url' => ['todo/index']],
                    ],
                    'activeCssClass' => 'active',
                ])
                ?>
                <div class="btn_menu dropdown"></div>
                <div class="right">
                    <?= Html::a('Настройки', ['user/setting']) ?>
                    <?= Html::a('Выйти', ['site/logout'], [
                            'data' => [
                                'method' => 'post',
                            ],
                        ]); ?>
                </div>
            </nav>
        </header>
        <?=$content;?>
    <?}?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
