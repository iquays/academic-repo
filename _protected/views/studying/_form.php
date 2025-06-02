<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Studying */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="studying-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
                <?= $form->field($model, 'teaching_id')->textInput() ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'mark')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
