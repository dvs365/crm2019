<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OrganizationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
		'js/organization.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}