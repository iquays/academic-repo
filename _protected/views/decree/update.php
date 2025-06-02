<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Decree */

$this->title = Yii::t('app', 'Update Decree: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decree List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="decree-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
