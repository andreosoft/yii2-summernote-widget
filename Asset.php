<?php

namespace common\widgets\summernote;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@bower/summernote';

    public $js = [
        'summernote.min.js',
    ];
    
    public $css = [
        'summernote.css',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}