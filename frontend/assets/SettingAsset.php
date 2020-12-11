<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SettingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/setting.js',
		'js/datepicker.js?1',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}