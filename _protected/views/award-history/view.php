<?php
// by Syauqi

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AwardHistory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Award History List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="award-history-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Award History List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= Yii::t('app', 'Award Detail') ?></h3>
                    </div>
                    <div class="box-body">
                        <?= DetailView::widget([
                            'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                            'template' => '<tr><th{captionOptions} class="columnLabel">{label}</th><td{contentOptions}>{value}</td></tr>',
                            'model' => $model,
                            'attributes' => [
                                'title',
                                'grantor',
                                [
                                    'attribute' => 'date',
                                    'format' => ['date', 'long'],
                                ]
                            ],
                        ]) ?>
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
                                    <?= Html::activeLabel($model, 'certificate') ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13">
                                    <?php
                                    if (empty($model->certificate)) {
                                        echo Yii::t('app', 'There is no file');
                                    } else {
                                        $file_parts = pathinfo($model->certificate);
                                        if ($file_parts['extension'] == 'pdf') {
                                            echo "<object style='width:100%; height:250px' type='application/pdf'  data='" . $model->getFileUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileUrl() . "'>Download the File</a></object>";
                                        } else {
                                            Html::img($model->getFileUrl(), ['style' => 'width:100%; height:450px', 'alt' => $model->certificate, 'title' => $model->certificate]);
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
            <?= Html::a("<i class='fa fa-trash-o'></i> " . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </section>

</div>
