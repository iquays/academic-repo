<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfessionalMembership */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="professional-membership-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Professional Membership Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-9">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-10 col-sm-7 col-md-7">
                            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-9 col-sm-5 col-md-4">
                            <?= $form->field($model, 'year')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'saveFormat' => 'yyyy',
                                'displayFormat' => 'yyyy',
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'startView' => 2,
                                        'minViewMode' => 'years',
                                        'defaultViewDate' => [
                                            'year' => date("Y", strtotime("-7 year")),
                                        ],
                                    ]
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group box box-success box-footer">
                <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
