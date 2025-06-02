<?php

use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lecturing */
/* @var $form yii\widgets\ActiveForm */
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

<div class="lecturing-form">
    <?php $form = ActiveForm::begin([
        'id' => 'Lecturing'
    ]); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-body">

                    <?= $form->field($model, 'course_id')->widget(Select2::className(), [
                        'data' => \app\models\Course::getCourseList(),
                        'theme' => Select2::THEME_BOOTSTRAP,
//                        'hideSearch' => true,
                        'options' => ['placeholder' => Yii::t('app', 'Choose course...')],
                    ])->label(Yii::t('app', "Course's Name")) ?>

                    <?= $form->field($model, 'lecturer_id')->widget(Select2::className(), [
                        'data' => \app\models\Lecturer::getLecturerList(),
                        'theme' => Select2::THEME_BOOTSTRAP,
//                        'hideSearch' => true,
                        'options' => ['placeholder' => Yii::t('app', 'Choose lecturer...')],
                    ])->label(Yii::t('app', "Lecturer's Name")) ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <?= $form->field($model, 'year')->widget(Select2::className(), [
                                'data' => \app\models\Lecturing::getAcademicYearList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose year...')],
                            ]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <?= $form->field($model, 'semester')->widget(Select2::className(), [
                                'data' => \app\models\Lecturing::getSemesterList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose semester...')],
                            ]) ?>
                        </div>
                    </div>
                    <?php
                    //                    echo $form->field($model, 'status')->textInput()
                    ?>

                </div>
            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', "Course's Participant List") ?></h3>
                </div>
                <div class="box-body row form-group kv-fieldset-inline">
                    <div id="student-list-container">
                        <div class="col-xs-12">
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
                            if (count($model->studyings) > 0) {
                                foreach ($model->studyings as $i => $studying) {
                                    echo "<tr><td style='text-align: center'></td><td>" . Html::encode($studying->student->name) . "</td><td>" .
                                        Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                            'class' => 'btn bg-red btn-xs',
                                            'onclick' => '$(this).closest("tr").remove()'
                                        ]) . "</td>" .
                                        Html::hiddenInput('Lecturing[student][]', $studying->student->id) . "</tr>";
                                }
                            }
                            ?>
                        </table>
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
