<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/client.js?2',
        'js/datepicker.js?2',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}