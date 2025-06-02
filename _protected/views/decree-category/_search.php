<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DecreeCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="decree-category-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'parent_category') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn bg-olive']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
