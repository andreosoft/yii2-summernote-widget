<?php

namespace andreosoft\summernote;

use yii\web\AssetBundle;

class AssetCodeMirrior extends AssetBundle
{
    public $sourcePath = '@bower/codemirror';
    /**
     * @inheritdoc
     */
    public $js = [
        'lib/codemirror.js',
        'addon/edit/matchbrackets.js',
        'mode/htmlmixed/htmlmixed.js',
        'mode/xml/xml.js',
        'addon/hint/show-hint.js',
        'addon/hint/html-hint.js',
        'addon/hint/xml-hint.js',
        'addon/format/formatting.js',
        
    ];
    public $css = [
        'lib/codemirror.css',
        'addon/hint/show-hint.css',
    ];
}
