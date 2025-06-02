<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DecreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Decree List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="decree-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Decree'), ['create'], ['class' => 'btn bg-olive']) ?>
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
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'No',
                            'vAlign' => GridView::ALIGN_TOP
                        ],
                        'title',
                        'number',
                        [
                            'attribute' => 'date',
                            'format' => ['date', 'long']
                        ],
//                        'decree_category_id',
                        'categoryName',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Menu',
                            'width' => '115px',
                            'template' => (Yii::$app->user->can('lecturer') or Yii::$app->user->can('student')) ? '{view}' : '{view} {update} {delete}',
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
