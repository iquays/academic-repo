<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Research */

$this->title = Yii::t('app', 'Update Research: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Research List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="research-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
