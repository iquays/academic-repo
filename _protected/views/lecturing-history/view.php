<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LecturingHistory */

$this->title = $model->course->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecturing History List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecturing-history-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Lecturing History List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app', 'Lecturing History Detail') ?></h3>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                    'template' => '<tr><th{captionOptions} class="columnLabel">{label}</th><td{contentOptions}>{value}</td></tr>',
                    'model' => $model,
                    'attributes' => [
                        'course.name',
                        'levelName',
                        'institution',
                        'year',
                    ],
                ]) ?>
            </div>
        </div>

        <div class="form-group box box-success box-footer">
            <?= Html::a("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn bg-blue']) ?>
            <?= Html::a("<i class='fa fa-trash-o'></i> " . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn bg-red',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </section>

</div>
