<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publication List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Publication List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= Yii::t('app', 'Publication Detail') ?></h3>
                    </div>
                    <div class="box-body">
                        <?= DetailView::widget([
                            'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                            'template' => '<tr><th{captionOptions} class="columnLabel">{label}</th><td{contentOptions}>{value}</td></tr>',
                            'model' => $model,
                            'attributes' => [
                                'title',
                                'publication_name',
                                'volume_number',
                                'year',
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= Yii::t('app', 'Writer List') ?>                        </h3>
                    </div>
                    <div class="box-body">
                        <?php if (count($model->publicatings) > 0): ?>
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th><?= Yii::t('app', 'No') ?></th>
                                    <th><?= Yii::t('app', 'Writer Name') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($model->publicatings as $i => $publicating): ?>
                                    <tr>
                                        <td class="columnNumber">
                                            <?= $i + 1 ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($publicating->profile->name) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p><?= Yii::t('app', 'No data') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= Yii::t('app', 'Supporting Document') ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover table-bordered">
                            <tr>
                                <td>
                                    <?= Html::activeLabel($model, 'file_paper') ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13">
                                    <?php
                                    if (empty($model->file_paper)) {
                                        echo Yii::t('app', 'There is no file');
                                    } else {
                                        $file_parts = pathinfo($model->file_paper);
                                        if ($file_parts['extension'] == 'pdf') {
                                            echo "<object style='width:100%; height:250px' type='application/pdf'  data='" . $model->getFilePaperUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFilePaperUrl() . "'>Download the File</a></object>";
                                        } else {
                                            Html::img($model->getFilePaperUrl(), ['style' => 'width:100%; height:450px', 'alt' => $model->file_paper, 'title' => $model->file_paper]);
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group box box-success box-footer">
            <?= Html::a("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn bg-blue']) ?>
            <?= Html::a("<i class='fa fa-trash-o'></i> " . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn bg-red',
                'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',],]) ?>
        </div>
    </section>

</div>
