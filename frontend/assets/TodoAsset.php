<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TodoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/select2.css',
    ];	
    public $js = [
		'js/select2.js',
        'js/todo.js',
        'js/datepicker-2.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}