<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LecturingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lecturing-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lecturer_id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'semester') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-olive']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
