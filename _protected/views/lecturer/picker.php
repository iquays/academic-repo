<?php
use kartik\grid\GridView;
use yii\helpers\Html;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LecturerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<div class="lecturer-picker">
    <section class="content-header">
        <h1><?= Yii::t('app', 'Choose Lecturer') ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <!--            <div class="box-body">-->

            <?= GridView::widget([
                'id' => 'searchLecturerGrid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type' => GridView::TYPE_ACTIVE,
//                        'footer' => false,
                    'after' => false,
                ],
                'toolbar' => false,
                'hover' => true,
                'pjax' => true,
                'pjaxSettings' => [
                    'options' => [
                        'id' => 'pjaxLecturer',
                        'timeout' => 9999999,
                        'enablePushState' => false,
                        'clientOptions' => ['method' => 'POST'],
                    ],
                ],
                'condensed' => true,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'vAlign' => GridView::ALIGN_TOP
                    ],
                    'name',
                    // buttons
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => 'Menu',
                        'template' => '{add}',
                        'vAlign' => GridView::ALIGN_MIDDLE,
                        'buttons' => [
                            'add' => function ($url, $model) {
                                return Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add'),
                                    [
                                        'class' => 'btn bg-olive btn-xs',
                                        'onclick' => 'addLecturerButtonClick("' . $model->name . '","' .
                                            $model->id . '")'
                                    ]);
                            }
                        ]
                    ]
                ], // columns
            ]); ?>

            <!--            </div>-->
        </div>
    </section>

</div>
<script>
    function addLecturerButtonClick(name, id) {
        modelName = $("form").attr('id');
        inputName = modelName + "[lecturer][]";
        $("#lecturerModal").modal("hide");
        $("#lecturer-list>tbody:last").append("<tr><td style='text-align: center'></td><td>" + name +
            "</td><td><button type='button' onclick='$(this).closest(\"tr\").remove()' class='btn bg-red btn-xs'><i class='fa fa-trash'></i>  <?= Yii::t('app', 'Remove')?> </button></td>" +
            "<input type='hidden' name='" + inputName + "' value='" + id + "'></input></tr>"
        );
    }

</script>