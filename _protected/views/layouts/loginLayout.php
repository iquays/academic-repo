<?php

use app\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

//AppAssetAdminlte::register($this);
AppAsset::register($this);

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="Description" content="Sistem Informasi Manajemen Program Dokter Spesialis Mikrobiologi Klinik Universitas Airlangga Surabaya.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>SIM PPDS Mikrobiologi Klinik Unair Surabaya</title>
    <?php $this->head() ?>

</head>

<body class="hold-transition login-page">
<div id="bg">
    <img src="<?= \yii\helpers\Url::to("@web/images/mk.jpg") ?>" alt="Background Logo">
</div>
<?php $this->beginBody() ?>

<!--<div class="wrapper">-->


<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<?= $content ?>

<!--</div>-->
<div style="position: absolute; left: 50%; bottom: 5px">
    <div style="text-align: center; color: darkgrey; position: relative; left: -50%">
        <p>Sistem Informasi Manajemen Program Pendidikan Dokter Spesialis Universitas Airlangga Surabaya</p>
    </div>
</div>
<?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>

<?php //} ?>
