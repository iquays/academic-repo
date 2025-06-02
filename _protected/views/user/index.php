<?php
use app\helpers\CssHelper;
use kartik\grid\GridView;
use yii\helpers\Html;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn bg-olive']) ?>
        </span>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => false,
                    'pjax' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'username',
                        'email:email',
                        // status
                        [
                            'attribute' => 'status',
                            'filter' => $searchModel->statusList,
                            'value' => function ($data) {
                                return $data->getStatusName($data->status);
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['class' => CssHelper::userStatusCss($model->status)];
                            }
                        ],
                        // role
                        [
                            'attribute' => 'item_name',
                            'filter' => $searchModel->rolesList,
                            'value' => function ($data) {
                                return $data->roleName;
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['class' => CssHelper::roleCss($model->roleName)];
                            }
                        ],
                        // buttons
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => "Menu",
                            'width' => '113px',
                            'viewOptions' => ['label' => '<i class="btn btn-info btn-xs fa fa-eye"></i>'],
                            'updateOptions' => ['label' => '<i class="btn bg-blue btn-xs fa fa-pencil"></i>'],
                            'deleteOptions' => ['label' => '<i class="btn bg-red btn-xs fa fa-trash-o"></i>'],
                            'vAlign' => 'top',

                        ], // ActionColumn

                    ], // columns

                ]); ?>
            </div>
        </div>
    </section>
</div>
