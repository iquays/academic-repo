<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LecturingHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lecturing-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'institution') ?>

    <?= $form->field($model, 'year') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-olive']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
