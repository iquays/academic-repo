<?php

/* @var $this yii\web\View */
/* @var $model app\models\Student */
$this->title = 'Error';
?>
<div class="unauthorized-view">

    <section class="content-header">
        <h1><?= Yii::t('app', 'Error') ?>       </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app', 'Unauthorized Access') ?></h3>
            </div>
            <div class="box-body">
                <p>No akses</p>
            </div>
        </div>

    </section>

</div>
