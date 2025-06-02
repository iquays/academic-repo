<?php

use kartik\builder\TabularForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Education List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-index">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <?php
                $form = ActiveForm::begin();
                $attribs = $model->formAttribs;
                ?>
                <?= TabularForm::widget([
                    'dataProvider' => $dataProvider,
                    'form' => $form,
                    'attributes' => $attribs,
                    'serialColumn' => [
                        'class' => '\kartik\grid\SerialColumn',
                        'header' => 'No',
                    ],
                    'actionColumn' => false,
                    'checkboxColumn' => false,
                    'gridSettings' => [
                        'bordered' => true,
                        'responsive' => false,
                        'summary' => '',
//                        'panel' => [
//                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
//                            'type' => GridView::TYPE_PRIMARY,
//                            'after' =>
//                                Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> ' . Yii::t('app', 'Save'), ['class' => 'btn bg-blue'])
//                        ]
                    ]
                ]); ?>
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Save'), ['class' => 'btn bg-blue']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>
