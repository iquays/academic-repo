<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = Yii::t('app', 'Create Profile');
$this->params['breadcrumbs'][] = ['label' => 'Daftar ' . Yii::t('app', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Tambah');
?>
<div class="profile-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </section>
</div>
