<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar ' . Yii::t('app', 'Education');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header ">
                <h3 class="box-title">Anda harus mengisi profil terlebih dulu sebelum mengakses halaman ini.</h3>
            </div>
            <div class="box-body">
                <?= Html::a('<i class=\'fa fa-plus\'></i>  ' . Yii::t('app', 'Create Profile'), ['profile/create'], ['class' => 'btn bg-blue']) ?>
            </div>
        </div>
    </section>
</div>