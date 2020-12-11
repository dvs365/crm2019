<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class App2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main2.css?2',
    ];
    public $js = [
        'js/jquery-2.2.4.js?2',
        'js/jquery-ui.min.js?2',
        'js/dynamicform.js?2',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
