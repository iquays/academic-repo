<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Work History List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-history-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Work History'), ['create'], ['class' => 'btn bg-olive']) ?>
            </span>
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

//                                'id',
                        'title',
                        'workplace',
//                        'city_id',
                        [
                            'attribute' => 'cityName',
                            'contentOptions' => ['style' => 'width: 160px;']
                        ],
                        [
                            'attribute' => 'start_date',
                            'format' => ['date', 'medium'],
                            'hAlign' => 'center',
                            'contentOptions' => ['style' => 'width: 110px;']
                        ],
                        [
                            'attribute' => 'end_date',
                            'format' => ['date', 'medium'],
                            'hAlign' => 'center',
                            'contentOptions' => ['style' => 'width: 120px;']
                        ],
                        // 'enddate',
                        // 'profile_id',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Menu',
                            'width' => '113px',
                            'viewOptions' => ['label' => '<i class="btn btn-info btn-xs fa fa-eye"></i>'],
                            'updateOptions' => ['label' => '<i class="btn bg-blue btn-xs fa fa-pencil"></i>'],
                            'deleteOptions' => ['label' => '<i class="btn bg-red btn-xs fa fa-trash-o"></i>'],
                            'vAlign' => 'top',
                        ],


                    ],
                ]); ?>
            </div>
        </div>
    </section>
</div>
