<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResearchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Research List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="research-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i>  " . Yii::t('app', 'Add Research'), ['create'], ['class' => 'btn bg-olive']) ?>
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

//                        'id',
                        'title',
                        'funding_source',
                        [
                            'attribute' => 'funding_amount',
                            'format' => 'currency',
                            'hAlign' => 'right',
                            'contentOptions' => ['style' => 'width: 140px;']
                        ],
                        [
                            'attribute' => 'year',
                            'hAlign' => 'center',
                            'contentOptions' => ['style' => 'width: 70px;']
                        ],

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
