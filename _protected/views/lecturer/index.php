<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LecturerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lecturer List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lecturer-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <span class="pull-right">
                    <?= Html::a("<i class='fa fa-plus'></i>  " . Yii::t('app', 'Add Lecturer'), ['create'], ['class' => 'btn btn-success']) ?>
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
                    'hover' => true,
                    'pjax' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'No',
                            'vAlign' => GridView::ALIGN_TOP
                        ],

                        'nip',
                        [
                            'attribute' => 'name',
                            'value' => function ($model) {
                                return $model->front_title . " " . $model->name . ", " . $model->back_title;
                            },
                        ],
                        'userName',
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
