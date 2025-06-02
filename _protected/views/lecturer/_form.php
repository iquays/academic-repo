<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $lecturer app\models\Lecturer */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lecturer-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Lecturer Detail') ?></h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-9 col-sm-5">
                            <?= $form->field($lecturer, 'nip')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-5 col-sm-3">
                            <?= $form->field($lecturer, 'front_title')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-5 col-sm-3">
                            <?= $form->field($lecturer, 'back_title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-10 col-sm-6">
                            <?php
                            if ($user->scenario === 'create') {
                                echo $form->field($lecturer, 'name')->textInput(['maxlength' => true, 'onchange' => 'onNameChange()']);
                            } else {
                                echo $form->field($lecturer, 'name')->textInput(['maxlength' => true]);
                            }
                            ?>
                        </div>
                        <div class="col-xs-8 col-sm-4">
                            <?php if ($user->scenario === 'create') {
                                $lecturer->status = \app\models\Lecturer::STATUS_ACTIVE;
                            } ?>
                            <?= $form->field($lecturer, 'status')->widget(Select2::className(), [
                                'data' => \app\models\Lecturer::getStatusList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose status...')],
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

<?php
//<script>
//$js = '
//        $(document).ready(function () {
//            $("#lecturer-name").blur(function () {
//                name = $(this).val().trim().toLowerCase();
//                nameArray = name.split(" ");
//                username = nameArray[0];
//                nameArray.forEach(function(item, i){
//                    if (i > 0) {
//                        username = username + item[0];
//                    }
//                });
//                $("#user-username").val(username);
//                $("#user-password").val(username+"231");
//            });
//        });
//    ';
//$this->registerJs($js);
//</script>
?>

<script>
    function onNameChange() {
        name = $("#lecturer-name").val().trim().toLowerCase();
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

