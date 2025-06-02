<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List of ') . Yii::t('app', 'Course'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                                <?php if (Yii::$app->user->can('admin')): ?>
                                <?php endif; ?>

                                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Course'), ['create'], ['class' => 'btn bg-olive']) ?>
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Course List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <?= DetailView::widget([
                    'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                    'template' => '<tr><th{captionOptions} class="columnLabel">{label}</th><td{contentOptions}>{value}</td></tr>',
                    'model' => $model,
                    'attributes' => [
                        'code',
                        'name',
                        'sks',
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
