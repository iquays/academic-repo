<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header ">
                    <h3 class="box-title">Data Pribadi</h3>
                </div>
                <div class="box-body">

                    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [

                            'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                            'initialPreview' => [
                                [Html::img($model->getImageUrlThumbnail(), ['style' => 'height:160px', 'class' => 'file-preview-image', 'alt' => $model->picture, 'title' => $model->picture])]
                            ],
                            'showUpload' => false,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'layoutTemplates' => ['footer' => ''],
                        ]
                    ]);
                    ?>

                    <div class="row">
                        <div class="col-xs-7">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-5">
                            <?= $form->field($model, 'handphone_number')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <?php $regencyName = empty($model->birth_place) ? '' : $model->birthPlace->name; ?>
                            <?= $form->field($model, 'birth_place')->widget(Select2::className(), [
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
                        <div class="col-xs-4">
                            <?= $form->field($model, 'birth_date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'startView' => 2,
                                        'defaultViewDate' => [
                                            'year' => date("Y", strtotime("-30 year")),
                                        ],
                                    ],
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <?= $form->field($model, 'marital_status')->widget(Select2::className(), [
                                'data' => \app\models\Profile::getMaritalStatusList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose marital status...')],
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-sm-12 col-md-6">
            <div class="box box-info">
                <div class="box-header ">
                    <h3 class="box-title">Data Pendidikan Dokter</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php $universityName = empty($model->almamater_id) ? '' : $model->university->name; ?>
                            <?= $form->field($model, 'almamater_id')->widget(Select2::className(), [
                                'initValueText' => $universityName,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => ['placeholder' => Yii::t('app', 'Choose University...')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['university/searchajax']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(university) { return university.text; }'),
                                    'templateSelection' => new JsExpression('function (university) { return university.text; }'),
                                ],]) ?>
                        </div>
                        <div class="col-xs-3">
                            <?= $form->field($model, 'almamater_acreditation')->widget(Select2::className(), [
                                'data' => \app\models\University::getAccreditationLevelList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose...')],
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <?= $form->field($model, 'gpa_degree')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-6">
                            <?= $form->field($model, 'gpa_profession')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'study_period')->textInput() ?>

                    <?= $form->field($model, 'mandatory_workplace')->textInput(['maxlength' => true]) ?>


                </div>
            </div>
            <div class="box box-warning">
                <div class="box-header ">
                    <h3 class="box-title">Data Pekerjaan</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <?= $form->field($model, 'work_status')->widget(Select2::className(), [
                                'data' => \app\models\Profile::getWorkStatusList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose status...')],
                            ]) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'institution')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
