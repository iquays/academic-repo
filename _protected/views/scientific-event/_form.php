<?php

use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ScientificEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scientific-event-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Scientific Event Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-md-9">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-md-9">
                            <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-sm-5 col-md-5">
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
                        <div class="col-xs-5 col-sm-5 col-md-3">
                            <?= $form->field($model, 'date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,

                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-5 col-md-4">
                            <?= $form->field($model, 'position')->widget(Select2::className(), [
                                'data' => \app\models\ScientificEvent::getPositionList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose Position...')],
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
