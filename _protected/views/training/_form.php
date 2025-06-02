<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Training */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="training-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Training Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-7">
                            <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-11 col-sm-5">
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
                        <div class="col-xs-10 col-sm-6">
                            <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ]) ?>
                        </div>
                        <div class="col-xs-10 col-sm-6">
                            <?= $form->field($model, 'end_date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Supporting Document') ?></h3>
                </div>
                <div class="box-body">
                    <?php
                    $initialPreview = null;
                    if (!(empty($model->certificate))) {
                        $file_parts = pathinfo($model->certificate);
                        if ($file_parts['extension'] == 'pdf') {
                            $initialPreview = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileUrl() . "'>Download the File</a></object>";
                        } else {
                            $initialPreview = Html::img($model->getFileUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image', 'alt' => $model->certificate, 'title' => $model->certificate]);
                        }

                    }
                    ?>

                    <?= $form->field($model, 'file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/*, application/pdf'],
                        'pluginOptions' => [
                            'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                            'allowedFileExtensions' => ['pdf', 'jpg', 'gif', 'png'],
                            $model->certificate == null ? null : 'initialPreview' => $initialPreview,
                            'showUpload' => false,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'browseClass' => 'btn bg-navy btn-sm',
                            'previewSettings' => ['object' => ['width' => '95%', 'height' => '150px']],
                            'layoutTemplates' => ['footer' => ''],
                        ]]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
