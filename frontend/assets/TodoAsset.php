<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TodoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/select2.css?2',
    ];	
    public $js = [
		'js/select2.js?2',
        'js/todo.js?2',
        'js/datepicker-2.js?2',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}