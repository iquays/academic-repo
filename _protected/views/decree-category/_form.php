<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DecreeCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="decree-category-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parent_category')->textInput() ?>

        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton($model->isNewRecord ? "<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save') : "<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn bg-olive' : 'btn
        bg-blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
