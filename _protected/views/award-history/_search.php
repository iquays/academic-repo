<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AwardHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="award-history-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'grantor') ?>

    <?= $form->field($model, 'certificate') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'profile_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-olive']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
