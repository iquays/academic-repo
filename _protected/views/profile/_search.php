<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'picture') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'birth_place') ?>

    <?= $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'work_status') ?>

    <?php // echo $form->field($model, 'institution') ?>

    <?php // echo $form->field($model, 'almamater') ?>

    <?php // echo $form->field($model, 'almamater_acreditation') ?>

    <?php // echo $form->field($model, 'gpa_degree') ?>

    <?php // echo $form->field($model, 'gpa_profession') ?>

    <?php // echo $form->field($model, 'study_period') ?>

    <?php // echo $form->field($model, 'mandatory_workplace') ?>

    <?php // echo $form->field($model, 'handphone_number') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-blue']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
