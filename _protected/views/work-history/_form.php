<?php

use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WorkHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-history-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Work History Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-10 col-sm-7 col-md-5">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <?= $form->field($model, 'workplace')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?php $regencyName = empty($model->city_id) ? '' : $model->city->name; ?>
                            <?= $form->field($model, 'city_id')->widget(Select2::className(), [
                                'initValueText' => $regencyName,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => ['placeholder' => Yii::t('app', 'Choose Regency...')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['regency/searchajax']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(regency) { return regency.text; }'),
                                    'templateSelection' => new JsExpression('function (regency) { return regency.text; }'),
                                ],]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-9 col-sm-6">
                            <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ]) ?>
                        </div>
                        <div class="col-xs-9 col-sm-6">
                            <?= $form->field($model, 'end_date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ])->hint(Yii::t('app', "Leave empty if you're still working here")) ?>
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
