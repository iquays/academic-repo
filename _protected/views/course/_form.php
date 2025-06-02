<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Course Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-10 col-sm-4 col-md-3">
                            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-sm-5 col-md-3">
                            <?= $form->field($model, 'sks')->widget(Select2::className(), [
                                'data' => \app\models\Course::getSksList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'hideSearch' => true,
                                'options' => ['placeholder' => Yii::t('app', 'Choose SKS value...')],
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
