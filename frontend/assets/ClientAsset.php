<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/client.js',
        'js/datepicker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}