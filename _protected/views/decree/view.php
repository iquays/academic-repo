<?php
// by Syauqi

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Decree */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decree List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="decree-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?php if (Yii::$app->user->can('admin')): ?>
                    <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Decree'), ['create'], ['class' => 'btn bg-olive']) ?>
                <?php endif; ?>
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Decree List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= Yii::t('app', 'Decree Detail') ?></h3>
                                    </div>
                                    <div class="box-body">
                                        <?= DetailView::widget([
                                            'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                                            'template' => '<tr><th{captionOptions} class="columnLabel">{label}</th><td{contentOptions}>{value}</td></tr>',
                                            'model' => $model,
                                            'attributes' => [
                                                'title',
                                                'number',
                                                [
                                                    'attribute' => 'date',
                                                    'format' => ['date', 'long'],
                                                ],
                                                'decree_category_id',
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= Yii::t('app', 'Related Parties') ?>
                                            <small><strong> - <?= strtoupper(Yii::t('app', 'Lecturer')) ?></strong></small>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <?php if ($model->for_all_lecturer == 1): ?>
                                            <p><?= Yii::t('app', 'This decree is for all lecturers.') ?></p>
                                        <?php else: ?>
                                            <?php if (empty($model->hasLecturers)): ?>
                                                <p><?= Yii::t('app', 'There are no lecturer related with this decree.') ?></p>
                                            <?php else: ?>
                                                <p><?= Yii::t('app', 'Related lecturer list.') ?></p>
                                                <table class="table table-bordered table-striped table-hover table-condensed" id="lecturer-list">
                                                    <tr>
                                                        <th class="col-xs-1" style='text-align: center'>No</th>
                                                        <th class="col-xs-9"><?= Yii::t('app', 'Lecturer Name') ?></th>
                                                    </tr>
                                                    <?php
                                                    foreach ($model->hasLecturers as $i => $hasLecturer) {
                                                        echo "<tr><td style='text-align: center'></td><td>" . Html::encode($hasLecturer->lecturer->name) . "</td><td></tr>";
                                                    }
                                                    ?>
                                                </table>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= Yii::t('app', 'Related Parties') ?></h3>
                                        <small><strong> - <?= strtoupper(Yii::t('app', 'Student')) ?></strong></small>
                                    </div>
                                    <div class="box-body">
                                        <?php if ($model->for_all_student == 1): ?>
                                            <p><?= Yii::t('app', 'This decree is for all students.') ?></p>
                                        <?php else: ?>
                                            <?php if (empty($model->hasStudents)): ?>
                                                <p><?= Yii::t('app', 'There are no student related with this decree.') ?></p>
                                            <?php else: ?>
                                                <p><?= Yii::t('app', 'Related student list.') ?></p>
                                                <table class="table table-bordered table-striped table-hover table-condensed" id="student-list">
                                                    <tr>
                                                        <th class="col-xs-1" style='text-align: center'>No</th>
                                                        <th class="col-xs-9"><?= Yii::t('app', 'Lecturer Name') ?></th>
                                                    </tr>
                                                    <?php
                                                    foreach ($model->hasStudents as $i => $hasStudent) {
                                                        echo "<tr><td style='text-align: center'></td><td>" . Html::encode($hasStudent->student->name) . "</td><td></tr>";
                                                    }
                                                    ?>
                                                </table>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= Yii::t('app', 'Supporting Document') ?></h3>
                            </div>
                            <div class="box-body">
                                <?php
                                if (empty($model->file_name)) {
                                    echo Yii::t('app', 'There is no file');
                                } else {
                                    $file_parts = pathinfo($model->file_name);
                                    if ($file_parts['extension'] == 'pdf') {
                                        echo "<object style='width:100%; height:450px' type='application/pdf'  data='" . $model->getFileUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileUrl() . "'>Download the File</a></object>";
                                    } else {
                                        Html::img($model->getFileUrl(), ['style' => 'width:100%; height:450px', 'alt' => $model->file_name, 'title' => $model->file_name]);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (Yii::$app->user->can('admin')): ?>
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
                <?php endif; ?>
            </div>
        </div>


    </section>

</div>
