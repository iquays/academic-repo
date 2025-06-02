<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profile List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <span class="pull-right">
                <?= Html::a('<i class=\'fa fa-plus\'></i>  ' . Yii::t('app', 'Create Profile'), ['create'], ['class' => 'btn bg-olive']) ?>
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
//                        'picture',
                        'name',
//                        'birth_place',
                        [
                            'attribute' => 'birthPlace_name',
                            'value' => 'birthPlace.name',
                            'header' => Yii::t('app', 'Birth Place'),
                            'contentOptions' => ['style' => 'width: 170px;']
                        ],
                        [
                            'attribute' => 'birth_date',
                            'format' => ['date', 'long'],
                            'contentOptions' => ['style' => 'width: 130px;']
                        ],

                        // 'marital_status',
                        // 'work_status',
                        // 'institution',
                        // 'almamater',
                        // 'almamater_acreditation',
                        // 'gpa_degree',
                        // 'gpa_profession',
                        // 'study_period',
                        // 'mandatory_workplace',
                        // 'handphone_number',
                        // 'lat',
                        // 'lng',
                        // 'user_id',
                        // 'created_at',
                        // 'updated_at',
                        // 'created_by',
                        // 'updated_by',

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
