<?php

use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Research */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'options' => [
        'id' => 'profileModal',
        'tabIndex' => false
    ],
    'size' => 'modal-md',

    'closeButton' => false,
    'footer' => null,
]);
echo '<div id="profileModalContent"></div>';
Modal::end();


?>
<style>
    #researcher {
        counter-reset: Serial1; /* Set the Serial counter to 0 */
    }

    table#researcher td:first-child:before {
        counter-increment: Serial1; /* Increment the Serial counter */
        content: counter(Serial1); /* Display the counter */
    }
</style>

<div class="research-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Research Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <?= $form->field($model, 'funding_source')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <?= $form->field($model, 'funding_amount')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-5">
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
                    <h3 class="box-title"><?= Yii::t('app', 'Researcher List') ?></h3>
                    <span class="pull-right">
                                        <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Researcher'), [
                                            'id' => 'addResearcherButton',
                                            'value' => Url::to(Yii::$app->homeUrl . 'profile/picker-researcher'),
                                            'class' => 'btn bg-navy btn-xs',
                                            'onclick' => 'showProfileModal()'
                                        ]); ?>
                                        </span>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover" id="researcher">
                        <tr>
                            <th class="col-xs-1" style='text-align: center'>No</th>
                            <th class="col-xs-9"><?= Yii::t('app', 'Researcher Name') ?></th>
                            <th class="col-xs-2">Menu</th>
                        </tr>
                        <?php
                        if ($model->isNewRecord) {
                            echo "<tr><td style='text-align: center'></td><td>" . \app\models\Profile::findOne(Yii::$app->user->identity->profile_id)->name . "</td><td>" .
                                Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                    'class' => 'btn bg-red btn-xs',
                                    'onclick' => '$(this).closest("tr").remove()'
                                ]) . "</td>" .
                                Html::hiddenInput('Research[researcher][]', Yii::$app->user->identity->profile_id) . "</tr>";
                        }
                        if (count($model->researchings) > 0) {
                            foreach ($model->researchings as $i => $researching) {
                                echo "<tr><td style='text-align: center'></td><td>" . Html::encode($researching->profile->name) . "</td><td>" .
                                    Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                        'class' => 'btn bg-red btn-xs',
                                        'onclick' => '$(this).closest("tr").remove()'
                                    ]) . "</td>" .
                                    Html::hiddenInput('Research[researcher][]', $researching->profile->id) . "</tr>";
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
                        <?php
                        $initialPreviewProposal = null;
                        if (!(empty($model->file_proposal))) {
                            $file_parts = pathinfo($model->file_proposal);
                            if ($file_parts['extension'] == 'pdf') {
                                $initialPreviewProposal = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileProposalUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileProposalUrl() . "'>Download the File</a></object>";
                            } else {
                                $initialPreviewProposal = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileProposalUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileProposalUrl() . "'>Download the File</a></object>";
                            }
                        }

                        $initialPreviewReport = null;
                        if (!(empty($model->file_report))) {
                            $file_parts = pathinfo($model->file_report);
                            if ($file_parts['extension'] == 'pdf') {
                                $initialPreviewReport = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileReportUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileReportUrl() . "'>Download the File</a></object>";
                            } else {
                                $initialPreviewReport = "<object style='width:100%' type='application/pdf'  data='" . $model->getFileReportUrl() . "' ><p>Sorry, the plugin is not supported</p><a href='" . $model->getFileReportUrl() . "'>Download the File</a></object>";
                            }
                        }
                        ?>

                        <div class="col-xs-12">
                            <?php
                            echo $form->field($model, 'fileProposal')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'application/pdf, application/doc, application/docx'],
                                'pluginOptions' => [
                                    'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                                    'allowedFileExtensions' => ['pdf', 'doc', 'docx'],
                                    $model->file_proposal == null ? null : 'initialPreview' => $initialPreviewProposal,
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
                        <div class="col-xs-12">
                            <?= $form->field($model, 'fileReport')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'application/pdf, application/doc, application/docx'],
                                'pluginOptions' => [
                                    'browseIcon' => '<i class="fa fa-folder-open"></i> ',
                                    'allowedFileExtensions' => ['pdf', 'doc', 'docx'],
                                    $model->file_report == null ? null : 'initialPreview' => $initialPreviewReport,
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

    //$js = '
    var researcherCounter = 1;

    function showProfileModal() {
        $("#profileModal").modal("show");
        if (researcherCounter == 1) {
            $("#profileModalContent").load($("#addResearcherButton").attr("value"));
        }
        researcherCounter++;
    }
    //    ';

    //$this->registerJs($js);

</script>
