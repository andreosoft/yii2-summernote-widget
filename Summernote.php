<?php

namespace andreosoft\summernote;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\Url;

class Summernote extends InputWidget {

    public $editorOptions = [
        
/*
            'font-styles' => false, //Font styling, e.g. h1, h2, etc. Default true
            'emphasis' => true, //Italics, bold, etc. Default true
            'lists' => true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            'html' => false, //Button which allows you to edit the generated HTML. Default false
            'link' => false, //Button to insert a link. Default true
            'image' => false, //Button to insert an image. Default true,
            'color' => false, //Button to change color of font       
*/    ];
    public function init() {
        parent::init();
        
        $imageIndex = Url::to(['/filemanager/image/index', 'extenalAction' => true]);
        if (isset($this->editorOptions['height'])) {
            $height = $this->editorOptions['height'];
        } else {
            $height = 200;
        }
        $js = <<<JS
{
        disableDragAndDrop: true,
        height: $height,
        codemirror: { 
            lineNumbers: true,
            lineWrapping: true,
            mode: "text/html",
            extraKeys: {
                'Ctrl-Space': function(cm) {
                    cm.showHint(cm, cm.htmlHint);
                    },
                'Alt-F': function(cm) {
                        var range = { from: cm.getCursor(true), to: cm.getCursor(false) };
                        cm.autoFormatRange(range.from, range.to);
                    },
                'Ctrl-S': function(cm) {
                    element.text(cm.getValue());
                    }
                }
        },
        emptyPara: '',
        toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'image', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
        ],
        buttons: {
        image: function() {
                        var ui = $.summernote.ui;

                        // create button
                        var button = ui.button({
                                contents: '<i class="note-icon-picture" />',
                                tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
                                click: function () {
                                        $('#modal-image').remove();

                                        $.ajax({
                                                url: '$imageIndex',
                                                dataType: 'html',
                                                beforeSend: function() {
                                                        $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                                        $('#button-image').prop('disabled', true);
                                                },
                                                complete: function() {
                                                        $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
                                                        $('#button-image').prop('disabled', false);
                                                },
                                                success: function(html) {

                                                        $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                                                        $('#modal-image').modal('show');

                                                        $('#modal-image').delegate('a.thumbnail', 'click', function(e) {
                                                                e.preventDefault();

                                                                $(element).summernote('insertImage', $(this).attr('href'), function (image) {
                                                                            image.css('width', '25%'); 
                                                                        });

                                                                $('#modal-image').modal('hide');
                                                        });
                                                }
                                        });						
                                }
                        });

                        return button.render();
                }
        }
}               
JS;
        $id = Json::encode('#'.$this->options['id']);
        $view = $this->getView();
        $jsData = "(function() {"
                . "var element = $($id);"
                . "$(element).summernote(";
//        $jsData .= empty($this->editorOptions) ? '' : (Json::encode($this->editorOptions));
        $jsData .= $js;
        $jsData .= ");"
                . "})();";
        
        $view->registerJs($jsData);
        AssetCodeMirrior::register($view);
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
