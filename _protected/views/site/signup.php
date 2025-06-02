<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

use kartik\password\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Signup');
?>
<div class="site-signup login-box">

    <div class="login-logo">
        <a>Mikrobiologi<b>Klinik</b></a>
    </div>
    <div class="login-box-body">

        <p><?= Yii::t('app', 'Please fill out the following fields to signup:') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(
            ['placeholder' => Yii::t('app', 'Create your username'), 'autofocus' => true]) ?>

        <?= $form->field($model, 'email')->input('email', ['placeholder' => Yii::t('app', 'Enter your e-mail')]) ?>

        <?= $form->field($model, 'password')->widget(PasswordInput::classname(),
            ['options' => ['placeholder' => Yii::t('app', 'Create your password')]]) ?>

        <div class="row">
            <div class="form-group col-xs-12">
                <?= Html::submitButton('<i class="fa fa-edit"></i> ' . Yii::t('app', 'Signup'),
                    ['class' => 'btn bg-blue', 'name' => 'signup-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a(Yii::t('app', 'Back to login page'), ['login']) ?>

        <?php if ($model->scenario === 'rna'): ?>
            <div style="color:#666;margin:1em 0">
                <i>*<?= Yii::t('app', 'We will send you an email with account activation link.') ?></i>
            </div>
        <?php endif ?>

    </div>
</div>