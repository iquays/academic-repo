<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $student app\models\Student */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Student Detail') ?></h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">
                            <?= $form->field($student, 'nim')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-10 col-sm-6">
                            <?php
                            if ($user->scenario === 'create') {
                                echo $form->field($student, 'name')->textInput(['maxlength' => true, 'onchange' => 'onNameChange()']);
                            } else {
                                echo $form->field($student, 'name')->textInput(['maxlength' => true]);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-4 col-md-3">
                            <?php $student->entry_year = date("Y", strtotime("-0 year")) ?>
                            <?= $form->field($student, 'entry_year')->widget(Select2::className(), [
                                'data' => \app\models\Student::getAcademicYearList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose year...')],
                            ]) ?>
                        </div>
                        <div class="col-xs-9 col-sm-4 col-md-4">
                            <?= $form->field($student, 'entry_semester')->widget(Select2::className(), [
                                'data' => \app\models\Student::getEntrySemesterList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose semester...')],
                            ]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <?= $form->field($student, 'toefl_score')->textInput(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <?= $form->field($student, 'financial_source')->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-xs-10 col-sm-6">
                            <?= $form->field($student, 'guardian_lecturer_id')->widget(Select2::className(), [
                                'data' => \app\models\Lecturer::getLecturerList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
//                        'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose lecturer...')],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Account Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">
                            <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-10 col-sm-6">
                            <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($user->scenario === 'create'): ?>
                            <div class="col-xs-10 col-sm-4">
                                <?= $form->field($user, 'password')->textInput(['maxlength' => true]) ?>
                            </div>
                        <?php else: ?>
                            <div class="col-xs-10 col-sm-7">
                                <?= $form->field($user, 'password')->textInput(['maxlength' => true, 'placeholder' => yii::t('app', 'Fill only to change the password')]) ?>
                            </div>
                        <?php endif; ?>
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
    function onNameChange() {
        name = $("#student-name").val().trim().toLowerCase();
        nameArray = name.split(" ");
        username = nameArray[0];
        nameArray.forEach(function (item, i) {
            if (i > 0) {
                username = username + item[0];
            }
        });
        $("#user-username").val(username);
        $("#user-password").val(username + "231");
    }

</script>
