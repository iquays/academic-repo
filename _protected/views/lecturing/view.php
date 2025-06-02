<?php
// by Syauqi

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lecturing */

$this->title = $model->courseName . ' (' . $model->lecturerName . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecturing List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecturing-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Lecturing List'), ['index'], ['class' => 'btn bg-blue']) ?>
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
                        'courseName',
                        'lecturerName',
                        [
                            'attribute' => 'year',
                            'value' => function ($model) {
                                return $model->year . '/' . ($model->year + 1);
                            }
                        ],
                        'semesterName',
//                        'status',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app', "Course's Participant List") ?></h3>
            </div>
            <div class="box-body">
                <?php if (empty($model->studyings)): ?>
                    <p><?= Yii::t('app', 'There are no student related with this decree.') ?></p>
                <?php else: ?>
                    <table class="table table-bordered table-striped table-hover table-condensed" id="student-list">
                        <tr>
                            <th class="col-xs-1" style='text-align: center'>No</th>
                            <th class="col-xs-9"><?= Yii::t('app', 'Student Name') ?></th>
                        </tr>
                        <?php
                        foreach ($model->studyings as $i => $studying) {
                            echo "<tr><td style='text-align: center'></td><td>" . Html::encode($studying->student->name) . "</td><td></tr>";
                        }
                        ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group box box-success box-footer">
            <?= Html::a("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn bg-blue']) ?>
            <?= Html::a("<i class='fa fa-trash-o'></i> " . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger',
                'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',],]) ?>
        </div>
    </section>

</div>
