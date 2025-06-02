<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = Yii::t('app', 'Login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="login-box">
        <div class="login-logo">
            <a>Mikrobiologi<b>Klinik</b></a>
        </div>
        <div class="login-box-body">
            <p>Masukkan username dan password anda</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'login-box-body']); ?>

            <?php //-- use email or username field depending on model scenario --// ?>
            <?php if ($model->scenario === 'lwe'): ?>
                <?= $form->field($model, 'email') ?>
            <?php else: ?>
                <?= $form->field($model, 'username', ['template' => '<div>{label}</div><div><div class="input-group">{input}<span class="input-group-addon"><span class="fa fa-user"></span></span></div>{error}{hint}</div>'])->textInput(['placeholder' => 'Nama User']) ?>
            <?php endif ?>

            <?= $form->field($model, 'password', ['template' => '<div>{label}</div><div><div class="input-group">{input}<span class="input-group-addon"><span class="fa fa-key"></span></span></div>{error}{hint}</div>'])
                ->passwordInput(['placeholder' => 'Kata Kunci']) ?>

            <div class="row">
                <div class="col-xs-8">
                    <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="form-group col-xs-4">
                    <?= Html::submitButton('<i class="fa fa-sign-in"></i> Login', ['class' => 'pull-right btn bg-blue', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <?= Yii::t('app', 'Forgot your password?') ?>
            <?= Html::a(Yii::t('app', 'reset it'), ['request-password-reset']) ?>
            <br/>
            <?= Html::a(Yii::t('app', 'Signup new user'), ['signup']) ?>
        </div>
    </div>

</div>

