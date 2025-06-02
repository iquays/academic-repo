<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LecturingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lecturing List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecturing-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Lecturing'), ['create'], ['class' => 'btn bg-olive']) ?>
            </span>
            <?php endif; ?>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'No',
                            'vAlign' => GridView::ALIGN_TOP
                        ],
                        'lecturerName',
                        'courseName',
                        [
                            'attribute' => 'year',
                            'value' => function ($model) {
                                return $model->year . '/' . ($model->year + 1);
                            },
                            'contentOptions' => ['style' => 'width: 130px;'],
                            'hAlign' => 'center'
                        ],
                        [
                            'attribute' => 'semester',
                            'value' => 'semesterName',
                            'filter' => \app\models\Lecturing::getSemesterList(),
                            'hAlign' => 'center',
                            'width' => '110px',
                        ],
                        // 'status',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Menu',
                            'width' => '115px',
                            'viewOptions' => ['label' => '<i class="btn btn-info btn-xs fa fa-eye"></i>'],
                            'updateOptions' => ['label' => '<i class="btn bg-blue btn-xs fa fa-pencil"></i>'],
                            'deleteOptions' => ['label' => '<i class="btn bg-red btn-xs fa fa-trash-o"></i>'],
                            'vAlign' => 'top'
                        ],


                    ],
                ]); ?>
            </div>
        </div>
    </section>
</div>
