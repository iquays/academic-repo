<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="community-service-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'place') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'funding_source') ?>

    <?php // echo $form->field($model, 'funding_amount') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-olive']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
