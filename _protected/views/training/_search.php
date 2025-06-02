<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'organizer') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'end_date') ?>
    <?php // echo $form->field($model, 'certificate') ?>

    <?php // echo $form->field($model, 'profile_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-blue']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
