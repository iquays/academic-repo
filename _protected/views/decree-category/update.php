<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DecreeCategory */

$this->title = Yii::t('app', 'Update Decree Category: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decree Category List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="decree-category-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
