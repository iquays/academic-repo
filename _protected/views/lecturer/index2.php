<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
                <?= Html::a("<i class='fa fa-plus'></i>  " . Yii::t('app', 'Add Lecturer'), ['create'], ['class' => 'btn bg-olive']) ?>
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
                        'nip',
                        [
                            'attribute' => 'name',
                            'value' => function ($model) {
                                return $model->front_title . " " . $model->name . ", " . $model->back_title;
                            },
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
                                        'id' => 'lecturer-index-view-profile-button',
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
