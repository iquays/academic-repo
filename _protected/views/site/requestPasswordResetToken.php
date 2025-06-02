<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Request password reset');
?>
<div class="site-request-password-reset login-box">

    <div class="login-logo">
        <a><?= Html::encode($this->title) ?></a>
    </div>
    <div class="login-box-body">

        <p><?= Yii::t('app', 'A link to reset password will be sent to your email.') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= $form->field($model, 'email', ['template' => '<div>{label}</div><div><div class="input-group">{input}<span class="input-group-addon"><span class="fa fa-envelope"></span></span></div>{error}{hint}</div>'])
            ->input('email',
                ['placeholder' => Yii::t('app', 'Please fill out your email.'), 'autofocus' => true]) ?>

        <div class="row">
            <div class="form-group col-xs-12">
                <?= Html::submitButton('<i class="fa fa-paper-plane"></i> ' . Yii::t('app', 'Send'), ['class' => 'btn bg-blue pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?= Html::a(Yii::t('app', 'Back to login page'), ['login']) ?>
    </div>

</div>
