<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScientificEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Scientific Event List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scientific-event-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Scientific Event'), ['create'], ['class' => 'btn bg-olive']) ?>
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
                        'name',
                        'organizer',
//                        'city_id',
                        [
                            'attribute' => 'cityName',
                            'contentOptions' => ['style' => 'width: 160px;']
                        ],
                        [
                            'attribute' => 'date',
                            'hAlign' => 'center',
                            'format' => ['date', 'medium'],
                            'contentOptions' => ['style' => 'width: 100px;']
                        ],
                        // 'position',

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
