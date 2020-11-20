<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/client.js?1',
        'js/datepicker.js?1',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}