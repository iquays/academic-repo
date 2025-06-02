<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

$this->title = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-change-password">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-11 col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h5><?= Yii::t('app', 'Enter your current and new password') ?></h5>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>
                            <?= $form->field($model, 'newPassword')->passwordInput() ?>
                            <?= $form->field($model, 'repeatNewPassword')->passwordInput() ?>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group box-footer">
                            <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app', 'Save'), ['class' => 'btn bg-blue']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
