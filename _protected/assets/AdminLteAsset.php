<?php


namespace app\assets;

use yii\web\AssetBundle;


class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte-customized/dist';

    public $css = [
        'css/AdminLTE.css',
        'css/skins/skin-blue.min.css',
    ];

    public $js = [
        'js/app.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.min.js',
    ];

//    public $publishOptions = [
//        'only' => [
//            'css/',
//            'js/',
//            'plugins/',
//        ]
//];

}
