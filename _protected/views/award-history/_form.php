<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AwardHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="award-history-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Award History Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-7">
                            <?= $form->field($model, 'grantor')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <?= $form->field($model, 'date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Supporting Document') ?></h3>
                </div>
                <div class="box-body">
                    <?php
                    $initialPreview = null;
                    if (!(empty($model->certificate))) {
                        $file_parts = pathinfo($model->certificate);
                        if ($file_parts['extension'] == 'pdf') {
                            $initialPreview = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileUrl() . "'>Download the File</a></object>";
                        } else {
                            $initialPreview = Html::img($model->getFileUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image', 'alt' => $model->certificate, 'title' => $model->certificate]);
                        }
                    }
                    ?>

                    <?= $form->field($model, 'file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/*, application/pdf'],
                        'pluginOptions' => [
                            'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                            'allowedFileExtensions' => ['pdf', 'jpg', 'gif', 'png'],
                            $model->certificate == null ? null : 'initialPreview' => $initialPreview,
                            'showUpload' => false,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'browseClass' => 'btn bg-navy btn-sm',
                            'previewSettings' => ['object' => ['width' => '95%', 'height' => '150px']],
                            'layoutTemplates' => ['footer' => ''],
                        ]]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
