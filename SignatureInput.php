<?php

namespace JCIT;

use yii\bootstrap\InputWidget;
use yii\helpers\Html;

class SignatureInput extends InputWidget
{
    public $inputId;
    public $inputName;
    public $height = '100px';

    public function init()
    {
        parent::init();
        if(!isset($this->inputId)) {
            $this->inputId = isset($this->model) ? Html::getInputId($this->model, $this->attribute) : $this->getId() . '-input';
            $this->inputName = isset($this->model) ? Html::getInputName($this->model, $this->attribute) : $this->getId() . '-name';
        }
    }

    public function registerAssets()
    {
        $view = $this->getView();
        $view->registerAssetBundle(SignatureInputAsset::class);
    }

    public function run()
    {
        parent::run();
        $this->registerAssets();

        $view = $this->getView();
        $id = $this->getId();

        $output = '';
        $output .= Html::input('hidden', $this->inputName, null, ['id' => $this->inputId]);
        $output .= Html::beginTag('div', ['class' => 'row']);
        $output .= Html::beginTag('div', ['class' => 'col-xs-12']);
        $output .= Html::tag('canvas', '', [
            'class' => ['signature-input-canvas'],
            'style' => [
                'border' => '1px solid black',
                'width' => '100%'
            ]
        ]);
        $output .= Html::endTag('div');
        $output .= Html::beginTag('div', ['class' => 'col-xs-12']);
        $output .= Html::button(\Yii::t('app', 'Clear'), ['class' => ['col-xs-12', 'btn', 'btn-default'], 'id' => $id . '-clear']);
        $output .= Html::endTag('div');
        $output .= Html::endTag('div');

        $view->registerJs(<<<JS
$(function(){
    var canvas = $("#$id .signature-input-canvas")[0];
    var signaturePad = new SignaturePad(canvas);
    
    signaturePad.onEnd = function(){
        var result = signaturePad.toDataURL();
        $('#$this->inputId').val(result);
    };
    
    $('#$id-clear').on('click', function(){
        $('#$this->inputId').val('');
        signaturePad.clear();
    });
})
JS
);

        return Html::tag('div', $output, [
            'id' => $id,
            'class' => ['signature-input']
        ]);
    }

}
