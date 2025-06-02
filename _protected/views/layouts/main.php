<?php

use app\assets\AppAsset;
use app\models\UserState;
use kartik\alert\AlertBlock;
use kartik\select2\Select2Asset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
Select2Asset::register($this);
//$this->registerJs("
//$('[data-toggle=\"popover\"]').popover();
//$('[data-toggle=\"tooltip\"]').tooltip();
//");

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        .breadcrumb {
            padding: 0px 15px;
        }

        .main-header .sidebar-toggle {
            font-family: fontello;
        }

        #lang-selected {
            color: lightgrey;
        }

    </style>

</head>

<?php
Yii::$app->user->isGuest ? $user_id = '99' : $user_id = Yii::$app->user->id;

$userModel = \app\models\Profile::findOne(Yii::$app->user->identity->profile_id);
$username = $userModel->name;
$userImage = $userModel->getImageUrlThumbnail();

?>
<?php if (UserState::findOne(['user_id' => $user_id])->value == 1): ?>
<body class="skin-blue sidebar-mini">
<?php else: ?>
<body class="skin-blue sidebar-mini sidebar-collapse">
<?php endif; ?>

<?php $this->beginBody() ?>
<div class="wrapper">
    <!--<div>-->
    <header class="main-header">
        <!-- Logo -->
        <a href="<?= Yii::$app->homeUrl ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">M<b>K</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Mikrobiologi<b>-Klinik</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li id="lang-selector2" class="dropdown">
                            <?php if (\app\models\Profile::findOne(Yii::$app->user->identity->profile_id)->language == 'id-ID'): ?>
                                <a id="lang-selected" name="id-ID" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-empty"></i> Indonesian
                                </a>
                            <?php else: ?>
                                <a id="lang-selected" name="en-EN" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-empty"></i> English
                                </a>
                            <?php endif; ?>
                            <ul class="dropdown-menu">
                                <li class="header"><a class="lang-option" name="id-ID" href="#"><i class="fa fa-flag-empty"></i> Indonesian</a></li>
                                <li class="header"><a class="lang-option" name="en-EN" href="#"><i class="fa fa-flag-empty"></i> English</a></li>
                            </ul>
                        </li>

                        <li class="dropdown user user-menu">
                            <a id="userDropdown" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!--                            <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                                <i class="fa fa-user"></i>
                                <span class="hidden-xs"><?= $username ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?= Html::img($userImage, ['class' => 'img-circle', 'alt' => 'User Image']) ?>
                                    <p>
                                        <?= $username ?>
                                        <small><?= Yii::$app->user->identity->username ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= Url::to(['site/change-password']) ?>" class="btn bg-olive btn-flat"><i class="fa fa-key"></i> <?= Yii::t('app', 'Change Password') ?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= Url::to(['site/logout']) ?>" data-method="post" class="btn bg-red btn-flat"><i class="fa fa-sign-out"></i> Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= Url::to(['site/login']) ?>" data-method="post"><i class="fa fa-sign-in"></i> Login</a>
                        </li>
                    <?php endif; ?>
                    <!-- Control Sidebar Toggle Button -->
                    <!--                    <li>-->
                    <!--                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                    <!--                    </li>-->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <?= Html::img($userImage, ['class' => 'img-circle', 'alt' => 'User Image']) ?>
                </div>
                <div class="pull-left info">
                    <p><?= $username ?></p>
                    <p class="text-muted"><?= Yii::$app->user->can('student') ? Yii::t('app', 'Student') : (Yii::$app->user->can('lecturer') ? Yii::t('app', 'Lecturer') : Yii::t('app', 'Administrator')) ?></p>
                </div>
            </div>
            <br/>

            <?php
            echo Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
//                    ['label' => '<i class="fa fa-sign-in"></i> <span>Login</span>', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => ['/site/dashboard'], 'visible' => Yii::$app->user->can('member')],
                    ['label' => '<i class="fa fa-user"></i><span>' . Yii::t('app', 'Curriculum Vitae') . '</span>', 'visible' => Yii::$app->user->can('member'), 'url' => ['/profile/view']],
                    [
                        'label' => '<i class="fa fa-user-circle-o"></i><span>' . Yii::t('app', 'Personal Data') . '</span>',
                        'visible' => Yii::$app->user->can('member'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => '<i class="fa fa-pencil-square-o"></i><span>' . Yii::t('app', 'Edit Profile') . '</span>', 'url' => ['/profile/update']],
                            ['label' => '<i class="fa fa-graduation-cap"></i><span>' . Yii::t('app', 'Education') . '</span>', 'url' => ['/education/tabularform']],
                            ['label' => '<i class="fa fa-certificate"></i><span>' . Yii::t('app', 'Training') . '</span>', 'url' => ['/training/index']],
                            ['label' => '<i class="fa fa-pencil"></i><span>' . Yii::t('app', 'Research') . '</span>', 'url' => ['/research/index']],
                            ['label' => '<i class="fa fa-file-text-o"></i><span>' . Yii::t('app', 'Publication') . '</span>', 'url' => ['/publication/index']],
                            ['label' => '<i class="fa fa-flask"></i><span>' . Yii::t('app', 'Scientific Event') . '</span>', 'url' => ['/scientific-event/index']],
                            ['label' => '<i class="fa fa-briefcase"></i><span>' . Yii::t('app', 'Lecturing History') . '</span>', 'visible' => Yii::$app->user->can('lecturer'), 'url' => ['/lecturing-history/index']],
                            ['label' => '<i class="fa fa-product-hunt"></i><span>' . Yii::t('app', 'Community Service') . '</span>', 'url' => ['/community-service/index']],
                            ['label' => '<i class="fa fa-building-o"></i><span>' . Yii::t('app', 'Work History') . '</span>', 'url' => ['/work-history/index']],
                            ['label' => '<i class="fa fa-trophy"></i><span>' . Yii::t('app', 'Award History') . '</span>', 'url' => ['/award-history/index']],
                            ['label' => '<i class="fa fa-user-md"></i><span>' . Yii::t('app', 'Professional Membership') . '</span>', 'url' => ['/professional-membership/index']],
                        ],
                    ],
                    [
                        'label' => '<i class="fa fa-book"></i><span>' . Yii::t('app', 'Academic') . '</span>',
                        'visible' => Yii::$app->user->can('member'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => '<i class="fa fa-list"></i><span>' . Yii::t('app', 'Lecturing List') . '</span>', 'visible' => Yii::$app->user->can('lecturer'), 'url' => ['/lecturing/index']],
                            ['label' => '<i class="fa fa-list"></i><span>' . Yii::t('app', 'Studying List') . '</span>', 'visible' => Yii::$app->user->can('student'), 'url' => ['/studying/index']],
                            ['label' => '<i class="fa fa-file-text"></i><span>' . Yii::t('app', 'Decree') . '</span>', 'url' => ['/decree/index']],
                        ],
                    ],
                    [
                        'label' => '<i class="fa fa-globe"></i><span>' . Yii::t('app', 'Public Information') . '</span>',
                        'visible' => Yii::$app->user->can('member') or Yii::$app->user->can('admin'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => '<i class="fa fa-user-male"></i><span>' . Yii::t('app', 'Lecturer List') . '</span>', 'url' => ['/lecturer/index2']],
                            ['label' => '<i class="fa fa-users"></i><span>' . Yii::t('app', 'Student List') . '</span>', 'url' => ['/student/index2']],
                        ],
                    ],
                    [
                        'label' => '<i class="fa fa-th-large"></i><span>' . Yii::t('app', 'Administration') . '</span>',
                        'visible' => Yii::$app->user->can('admin'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => '<i class="fa fa-user-male"></i><span>' . Yii::t('app', 'Lecturer') . '</span>', 'url' => ['/lecturer/index']],
                            ['label' => '<i class="fa fa-users"></i><span>' . Yii::t('app', 'Student') . '</span>', 'url' => ['/student/index']],
                            ['label' => '<i class="fa fa-list"></i><span>' . Yii::t('app', 'Lecturing') . '</span>', 'url' => ['/lecturing/index']],
                            ['label' => '<i class="fa fa-file-text"></i><span>' . Yii::t('app', 'Decree') . '</span>', 'url' => ['/decree/index']],
                        ],
                    ],
                    [
                        'label' => '<i class="fa fa-th-large"></i><span>' . Yii::t('app', 'Master Data') . '</span>',
                        'visible' => Yii::$app->user->can('admin'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => '<i class="fa fa-list"></i><span>' . Yii::t('app', 'Course') . '</span>', 'url' => ['/course/index']],
                            ['label' => '<i class="fa fa-list"></i><span>' . Yii::t('app', 'Decree Category') . '</span>', 'url' => ['/decree-category/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-users"></i><span>' . Yii::t('app', 'User Management') . '</span>', 'visible' => Yii::$app->user->can('sadmin'), 'url' => ['/user/index']],
                    [
                        'label' => '<i class="fa fa-sign-out"></i> <span>Logout</span>',
                        'visible' => !Yii::$app->user->isGuest,
                        'url' => ['/site/logout'],
                        'template' => '<a href="{url}" data-method="post">{label} </i></a>',
                    ],
                ],
                'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                'encodeLabels' => false, //allows you to use html in labels
                'activateParents' => true,]);
            ?>

        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="row" style="height: 25px">
            <span class="pull-right">
                <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </span>
            </div>
        </section>
        <?= AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 10, // delay before alert is displayed
            'alertSettings' => [
                'info' => [
                    'pluginOptions' => [
                        'delay' => 10,
                        'timer' => 1300,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ],
                'warning' => [
                    'pluginOptions' => [
                        'delay' => 10,
                        'timer' => 1500,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ]
            ]
        ]) ?>
        <?php
        //        \yii\widgets\Pjax::begin()
        ?>
        <?= $content ?>
        <?php
        //        \yii\widgets\Pjax::end()
        ?>
    </div>
    <!--    <div class="container">-->
    <footer class="main-footer">
        <!--        <div class="pull-right hidden-xs">-->
        <!--            Powered by <a href="http://yiiframework.com" target="_blank">Yii2</a>-->
        <!--        </div>-->
        <!--        <i class="fa fa-copyright"></i> <a href="http://syauqi.lecturer.pens.ac.id" target="_blank">iquays - 2016</a>-->
    </footer>
    <!--    </div>-->

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>
    webRoot = <?= Yii::$app->homeUrl ?>;

    $(document).ready(function () {
        $(".lang-option").click(function () {
            if ($(this).attr("name") !== $("#lang-selected").attr("name")) {
                $.ajax({url: webRoot + "/profile/lang?value=" + $(this).attr("name") + "&currentUrl=" + window.location.href});
            }
        });
    });
</script>