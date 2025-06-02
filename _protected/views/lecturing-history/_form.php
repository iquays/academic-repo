<?php

use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LecturingHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lecturing-history-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Lecturing History Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <?= $form->field($model, 'course_id')->widget(Select2::className(), [
                                'data' => \app\models\Course::getCourseList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => ['placeholder' => Yii::t('app', 'Choose course...')],
                            ]) ?>
                        </div>
                        <div class="col-xs-10 col-sm-4">
                            <?= $form->field($model, 'level')->widget(Select2::className(), [
                                'data' => \app\models\LecturingHistory::getLevelList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose level...')],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-10">
                            <?= $form->field($model, 'institution')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-5 col-md-4 col-lg-3">
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
