<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudyingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Studying List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="studying-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-plus'></i> " . Yii::t('app', 'Add Studying'), ['create'], ['class' => 'btn bg-olive']) ?>
            </span>
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

//                        'id',
//                        'lecturing_id',
                        [
                            'attribute' => 'lecturing.lecturerName',
                            'header' => Yii::t('app', "Lecturer's Name"),
                        ],
                        [
                            'attribute' => 'lecturing.courseName',
                            'header' => Yii::t('app', "Course's Name"),
                        ],

//                        'student_id',
//                        'mark',
//                        'status',

//                        [
//                            'class' => 'kartik\grid\ActionColumn',
//                            'header' => 'Menu',
//                            'vAlign' => GridView::ALIGN_TOP
//                        ],


                    ],
                ]); ?>
            </div>
        </div>
    </section>
</div>
