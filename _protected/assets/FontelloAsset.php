<?php

namespace app\assets;

use yii\web\AssetBundle;

class FontelloAsset extends AssetBundle
{
    public $sourcePath = '@bower/fontello';

    public $css = [
        'css/fontello.css',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'font/*',
        ]
    ];

}