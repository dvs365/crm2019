<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BirthdayAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/calendar_birthday.css',
    ];	
    public $js = [
        'js/calendar_birthday.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}