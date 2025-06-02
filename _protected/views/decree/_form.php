<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

//use yii\bootstrap\ActiveForm;

//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Decree */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'options' => [
        'id' => 'lecturerModal',
        'tabIndex' => false
    ],
    'size' => 'modal-md',

    'closeButton' => false,
    'footer' => null,
]);
echo '<div id="lecturerModalContent"></div>';
Modal::end();

Modal::begin([
    'options' => [
        'id' => 'studentModal',
        'tabIndex' => false
    ],
    'size' => 'modal-md',

    'closeButton' => false,
    'footer' => null,
]);
echo '<div id="studentModalContent"></div>';
Modal::end();

?>

<style>
    #lecturer-list, #student-list {
        counter-reset: Serial1; /* Set the Serial counter to 0 */
    }

    table#lecturer-list td:first-child:before, table#student-list td:first-child:before {
        counter-increment: Serial1; /* Increment the Serial counter */
        content: counter(Serial1); /* Display the counter */
    }
</style>

<div class="decree-form">
    <?php $form = ActiveForm::begin([
            'id' => 'Decree',
            'options' => ['enctype' => 'multipart/form-data']]
    ); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Decree Detail') ?></h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-10">
                                            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-5">
                                            <?= $form->field($model, 'date')->widget(DateControl::classname(), [
                                                'type' => DateControl::FORMAT_DATE,
                                            ]) ?>
                                        </div>
                                        <div class="col-xs-9 col-sm-7">
                                            <?= $form->field($model, 'decree_category_id')->widget(Select2::className(), [
                                                'data' => \app\models\DecreeCategory::getDecreeCategoryList(),
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'hideSearch' => true,
                                                'options' => ['placeholder' => Yii::t('app', 'Choose category...')],
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Related Parties') ?>
                                        <small><strong> - <?= strtoupper(Yii::t('app', 'Lecturer')) ?></strong></small>
                                    </h3>
                                </div>
                                <div class="box-body row form-group kv-fieldset-inline">
                                    <?= Html::activeLabel($model, 'for_all_lecturer', [
                                        'class' => 'col-xs-4'
                                    ]) ?>
                                    <?php $model->isNewRecord ? $model->for_all_lecturer = 0 : null ?>
                                    <?= $form->field($model, 'for_all_lecturer')->radioList(['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')], ['inline' => true])->label(false) ?>
                                    <div id="lecturer-list-container">
                                        <div class="col-xs-12">
                                            <?= strtoupper(Yii::t('app', 'Lecturer List')) ?>
                                            <span class="pull-right">
                                                <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Lecturer'), [
                                                    'id' => 'addLecturerButton',
                                                    'value' => Url::to(Yii::$app->homeUrl . 'lecturer/picker'),
                                                    'class' => 'btn bg-navy btn-xs',
                                                    'onclick' => 'showLecturerModal()'
                                                ]); ?>
                                            </span>
                                        </div>
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="lecturer-list">
                                            <tr>
                                                <th class="col-xs-1" style='text-align: center'>No</th>
                                                <th class="col-xs-9"><?= Yii::t('app', 'Lecturer Name') ?></th>
                                                <th class="col-xs-2">Menu</th>
                                            </tr>
                                            <?php
                                            if (count($model->hasLecturers) > 0) {
                                                foreach ($model->hasLecturers as $i => $hasLecturer) {
                                                    echo "<tr><td style='text-align: center'></td><td>" . Html::encode($hasLecturer->lecturer->name) . "</td><td>" .
                                                        Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                                            'class' => 'btn bg-red btn-xs',
                                                            'onclick' => '$(this).closest("tr").remove()'
                                                        ]) . "</td>" .
                                                        Html::hiddenInput('Decree[lecturer][]', $hasLecturer->lecturer->id) . "</tr>";
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Related Parties') ?></h3>
                                    <small><strong> - <?= strtoupper(Yii::t('app', 'Student')) ?></strong></small>
                                </div>
                                <div class="box-body row form-group kv-fieldset-inline">
                                    <?= Html::activeLabel($model, 'for_all_student', [
                                        'class' => 'col-xs-5'
                                    ]) ?>
                                    <?php $model->isNewRecord ? $model->for_all_student = 0 : null ?>
                                    <?= $form->field($model, 'for_all_student')->radioList(['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')], ['inline' => true])->label(false) ?>
                                    <div id="student-list-container">
                                        <div class="col-xs-12">
                                            <?= strtoupper(Yii::t('app', 'Student List')) ?>
                                            <span class="pull-right">
                                                <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Student'), [
                                                    'id' => 'addStudentButton',
                                                    'value' => Url::to(Yii::$app->homeUrl . 'student/picker'),
                                                    'class' => 'btn bg-navy btn-xs',
                                                    'onclick' => 'showStudentModal()'
                                                ]); ?>
                                            </span>
                                        </div>
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="student-list">
                                            <tr>
                                                <th class="col-xs-1" style='text-align: center'>No</th>
                                                <th class="col-xs-9"><?= Yii::t('app', 'Student Name') ?></th>
                                                <th class="col-xs-2">Menu</th>
                                            </tr>
                                            <?php
                                            if (count($model->hasStudents) > 0) {
                                                foreach ($model->hasStudents as $i => $hasStudent) {
                                                    echo "<tr><td style='text-align: center'></td><td>" . Html::encode($hasStudent->student->name) . "</td><td>" .
                                                        Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                                            'class' => 'btn bg-red btn-xs',
                                                            'onclick' => '$(this).closest("tr").remove()'
                                                        ]) . "</td>" .
                                                        Html::hiddenInput('Decree[student][]', $hasStudent->student->id) . "</tr>";
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php
                                    $initialPreview = null;
                                    if (!(empty($model->file_name))) {
                                        $file_parts = pathinfo($model->file_name);
                                        if ($file_parts['extension'] == 'pdf') {
                                            $initialPreview = "<object style='width:100%; height:350px' type='application/pdf'  data='" . $model->getFileUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileUrl() . "'>Download the File</a></object>";
                                        } else {
                                            $initialPreview = Html::img($model->getFileUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image', 'alt' => $model->certificate, 'title' => $model->certificate]);
                                        }
                                    }
                                    ?>

                                    <?= $form->field($model, 'file')->label(false)->widget(FileInput::classname(), ['options' => ['accept' => 'image/*, application/pdf'],
                                        'pluginOptions' => [
                                            'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                                            'allowedFileExtensions' => ['pdf', 'jpg', 'gif', 'png'],
                                            $model->file_name == null ? null : 'initialPreview' => $initialPreview,
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
                </div>
            </div>
            <div class="form-group box box-success box-footer">
                <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>

    //$js = '
    var lecturerCounter = 1;
    function showLecturerModal() {
        $("#lecturerModal").modal("show");
        if (lecturerCounter === 1) {
            $("#lecturerModalContent").load($("#addLecturerButton").attr("value"));
        }
        lecturerCounter++;
    }

    var studentCounter = 1;
    function showStudentModal() {
        $("#studentModal").modal("show");
        if (studentCounter === 1) {
            $("#studentModalContent").load($("#addStudentButton").attr("value"));
        }
        studentCounter++;
    }

    //    ';

    //$this->registerJs($js);

</script>
