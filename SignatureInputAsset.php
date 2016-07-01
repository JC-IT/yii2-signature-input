<?php

namespace JCIT;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class SignatureInputAsset extends AssetBundle
{
    public $depends = [
        SignaturePadAsset::class,
        JqueryAsset::class
    ];
}