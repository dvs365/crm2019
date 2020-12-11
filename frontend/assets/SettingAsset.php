<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SettingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/setting.js?2',
		'js/datepicker.js?2',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}