<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Student List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <span class="pull-right">
                    <?= Html::a("<i class='fa fa-plus'></i>  " . Yii::t('app', 'Add Student'), ['create'], ['class' => 'btn bg-olive']) ?>
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
                    'pjax' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'No',
                            'vAlign' => GridView::ALIGN_TOP
                        ],

//                        'id',
                        'nim',
                        'name',
                        [
                            'attribute' => 'entry_year',
                            'hAlign' => 'center',
                            'value' => function ($model) {
                                return $model->entry_year . '/' . ($model->entry_year + 1);
                            },
                            'contentOptions' => ['style' => 'width: 130px;']
                        ],
                        [
                            'attribute' => 'entry_semester',
                            'value' => 'entrySemester',
                            'filter' => \app\models\Student::getEntrySemesterList(),
                            'hAlign' => 'center',
                            'contentOptions' => ['style' => 'width: 150px;']
                        ],
                        [
                            'attribute' => 'userName',
                            'hAlign' => 'center',
                            'contentOptions' => ['style' => 'width: 110px;']
                        ],

//                        'profile_id',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Menu',
                            'width' => '113px',
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
