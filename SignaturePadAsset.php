<?php

namespace JCIT;

use yii\web\AssetBundle;

class SignaturePadAsset extends AssetBundle
{
    public $sourcePath = '@bower/signature_pad/';

    public $js = [
        'signature_pad.min.js'
    ];
}