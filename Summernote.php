<?php

namespace common\widgets\summernote;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Summernote extends InputWidget {

    public $editorOptions = [
        
//        'toolbar' => []
/*             'font-styles' => false, //Font styling, e.g. h1, h2, etc. Default true
            'emphasis' => true, //Italics, bold, etc. Default true
            'lists' => true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            'html' => false, //Button which allows you to edit the generated HTML. Default false
            'link' => false, //Button to insert a link. Default true
            'image' => false, //Button to insert an image. Default true,
            'color' => false, //Button to change color of font       
*/    ];
    public function init() {
        parent::init();
        
        $id = Json::encode('#'.$this->options['id']);
        $view = $this->getView();
        $jsData = "$($id).summernote(".
        $jsData .= empty($this->editorOptions) ? '' : (Json::encode($this->editorOptions));
        $jsData .= ");";
        
        $view->registerJs($jsData);
        Asset::register($view);
    }

    public function run() {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

}
