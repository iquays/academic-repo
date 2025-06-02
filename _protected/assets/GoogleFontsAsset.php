<?php


namespace app\assets;

use yii\web\AssetBundle;


class GoogleFontsAsset extends AssetBundle
{
    public $sourcePath = '@bower/google-fonts';

    public $css = [
        'css/fonts.css',
    ];

}
