<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nim') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'profile_id') ?>

    <?= $form->field($model, 'entry_year') ?>

    <?php // echo $form->field($model, 'entry_semester') ?>

    <?php // echo $form->field($model, 'graduation_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-blue']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
