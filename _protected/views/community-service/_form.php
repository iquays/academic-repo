<?php

use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityService */
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
    #servicer {
        counter-reset: Serial1; /* Set the Serial counter to 0 */
    }

    table#servicer td:first-child:before {
        counter-increment: Serial1; /* Increment the Serial counter */
        content: counter(Serial1); /* Display the counter */
    }
</style>


<div class="community-service-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Community Service Detail') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-9 col-sm-4 col-md-4">
                            <?php $regencyName = empty($model->city_id) ? '' : $model->city->name; ?>
                            <?= $form->field($model, 'city_id')->widget(Select2::className(), [
                                'initValueText' => $regencyName,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => ['placeholder' => Yii::t('app', 'Choose Regency...')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['regency/searchajax']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(regency) { return regency.text; }'),
                                    'templateSelection' => new JsExpression('function (regency) { return regency.text; }'),
                                ],]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <?= $form->field($model, 'funding_source')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-xs-9 col-sm-4">
                            <?= $form->field($model, 'funding_amount')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-654 col-lg-4">
                            <?= $form->field($model, 'date')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Servicer List') ?></h3>
                    <span class="pull-right">
                    <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Servicer'), [
                        'id' => 'addServicerButton',
                        'value' => Url::to(Yii::$app->homeUrl . 'profile/picker-servicer'),
                        'class' => 'btn bg-navy btn-xs',
                        'onclick' => 'showProfileModal()'
                    ]); ?>
                    </span>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover" id="servicer">
                        <tr>
                            <th class="col-xs-1" style='text-align: center'>No</th>
                            <th class="col-xs-9"><?= Yii::t('app', 'Servicer Name') ?></th>
                            <th class="col-xs-2">Menu</th>
                        </tr>
                        <?php
                        if ($model->isNewRecord) {
                            echo "<tr><td style='text-align: center'></td><td>" . \app\models\Profile::findOne(Yii::$app->user->identity->profile_id)->name . "</td><td>" .
                                Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                    'class' => 'btn bg-red btn-xs',
                                    'onclick' => '$(this).closest("tr").remove()'
                                ]) . "</td>" .
                                Html::hiddenInput('CommunityService[servicer][]', Yii::$app->user->identity->profile_id) . "</tr>";
                        }
                        if (count($model->communityServicings) > 0) {
                            foreach ($model->communityServicings as $i => $communityServicing) {
                                echo "<tr><td></td><td>" . Html::encode($communityServicing->profile->name) . "</td><td>" .
                                    Html::button('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Remove'), [
                                        'class' => 'btn bg-red btn-xs',
                                        'onclick' => '$(this).closest("tr").remove()'
                                    ]) . "</td>" .
                                    Html::hiddenInput('CommunityService[servicer][]', $communityServicing->profile->id) . "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="form-group box box-success box-footer">
                <?= Html::submitButton("<i class='fa fa-floppy-o'></i> " . Yii::t('app', 'Save'), ['class' => 'btn bg-olive']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>

    //$js = '
    var servicerCounter = 1;

    function showProfileModal() {
        $("#profileModal").modal("show");
        if (servicerCounter == 1) {
            $("#profileModalContent").load($("#addServicerButton").attr("value"));
        }
        servicerCounter++;
    }
    //    ';

    //$this->registerJs($js);

</script>
