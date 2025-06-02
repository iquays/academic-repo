<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LecturingHistory */

$this->title = Yii::t('app', 'Update Lecturing History: ') . $model->courseName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecturing History') . ' List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courseName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lecturing-history-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
