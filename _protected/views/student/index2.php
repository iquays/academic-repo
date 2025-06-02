<?php
// For Academic Menu

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
//                        'profile_id',
                        [
                            'format' => 'raw',
                            'header' => 'Menu',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::a(
                                    '<i class="fa fa-eye"></i> ' . Yii::t('app', 'Curriculum Vitae'),
                                    Url::to(['profile/view', 'id' => $model->profile_id]),
                                    [
                                        'id' => 'student-index-view-profile-button',
//                                        'data-pjax' => true,
//                                        'action' => Url::to(['profile/view', 'id' => $model->profile_id]),
                                        'class' => 'btn btn-info btn-sm',
                                    ]
                                );
                            },
                            'contentOptions' => ['style' => 'width: 130px;'],
                            'hAlign' => 'center',
                        ],

                    ],
                ]); ?>
            </div>
        </div>
    </section>
</div>
