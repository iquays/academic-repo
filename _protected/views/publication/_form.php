<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Publication */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'options' => [
        'id' => 'profileModal',
        'tabIndex' => false
    ],
    'size' => 'modal-md',

    'closeButton' => false,
    'footer' => false,

]);
echo '<div id="profileModalContent"></div>';
Modal::end();

?>
<style>
    #writer {
        counter-reset: Serial1; /* Set the Serial counter to 0 */
    }

    table#writer td:first-child:before {
        counter-increment: Serial1; /* Increment the Serial counter */
        content: counter(Serial1); /* Display the counter */
    }
</style>


<div class="publication-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Publication Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <?= $form->field($model, 'publication_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
                            <?= $form->field($model, 'volume_number')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-7 col-sm-6 col-md-5 col-lg-4">
                            <?= $form->field($model, 'year')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'saveFormat' => 'yyyy',
                                'displayFormat' => 'yyyy',
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'startView' => 2,
                                        'minViewMode' => 'years',
                                        'defaultViewDate' => [
                                            'year' => date("Y", strtotime("-7 year")),
                                        ],
                                    ]
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Writer List') ?></h3>
                    <span class="pull-right">
                                        <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Writer'), [
                                            'id' => 'addWriterButton',
                                            'value' => Url::to(Yii::$app->homeUrl . 'profile/picker-writer'),
                                            'class' => 'btn bg-navy btn-xs',
                                            'onclick' => 'showProfileModal()'
                                        ]); ?>
                                    </span>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover" id="writer">
                        <tr>
                            <th class="col-xs-1" style='text-align: center'>No</th>
                            <th class="col-xs-9"><?= Yii::t('app', 'Writer Name') ?></th>
                            <th class="col-xs-2">Menu</th>
                        </tr>
                        <?php
                        if ($model->isNewRecord) {
                            echo "<tr><td style='text-align: center'></td><td>" . \app\models\Profile::findOne(Yii::$app->user->identity->profile_id)->name . "</td><td>" .
                                Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => '$(this).closest("tr").remove()'
                                ]) . "</td>" .
                                Html::hiddenInput('Publication[writer][]', Yii::$app->user->identity->profile_id) . "</tr>";
                        }
                        if (count($model->publicatings) > 0) {
                            foreach ($model->publicatings as $i => $publicating) {
                                echo "<tr><td></td><td>" . Html::encode($publicating->profile->name) . "</td><td>" .
                                    Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                        'class' => 'btn btn-danger btn-xs',
                                        'onclick' => '$(this).closest("tr").remove()'
                                    ]) . "</td>" .
                                    Html::hiddenInput('Publication[writer][]', $publicating->profile->id) . "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Supporting Document') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <?php
                            $initialPreview = null;
                            if (!(empty($model->file_paper))) {
                                $file_parts = pathinfo($model->file_paper);
                                if ($file_parts['extension'] == 'pdf') {
                                    $initialPreview = "<object style='width:100%' type='application/pdf'  data='" . $model->getFilePaperUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFilePaperUrl() . "'>Download the File</a></object>";
                                } else {
                                    $initialPreview = Html::img($model->getFilePaperUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image', 'alt' => $model->file_paper, 'title' => $model->file_paper]);
                                }
                            }
                            ?>

                            <?= $form->field($model, 'filePaper')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'application/pdf, application/doc, application/docx'],
                                'pluginOptions' => [
                                    'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                                    'allowedFileExtensions' => ['pdf', 'doc', 'docx'],
                                    $model->file_paper == null ? null : 'initialPreview' => $initialPreview,
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
        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    var writerCounter = 1;

    function showProfileModal() {
        $("#profileModal").modal("show");
        if (writerCounter == 1) {
            $("#profileModalContent").load($("#addWriterButton").attr("value"));
        }
        writerCounter++;
    }

</script>