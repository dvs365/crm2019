<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BirthdayAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';	
    public $js = [
        'js/calendar.js?2',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}