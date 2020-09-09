<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SettingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/setting.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}