<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Nenad Zivkovic <nenad@freetuts.org>
 *
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@bower/sq/';

    public $css = [
        'css/myApp.css',
    ];

    public $js = [
        'js/myApp.js'
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV,
    ];
    public $depends = [
        'app\assets\FontelloAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',

//        'app\assets\FontAwesomeAsset',
        'app\assets\GoogleFontsAsset',
        'app\assets\AdminLteAsset',
    ];
}
