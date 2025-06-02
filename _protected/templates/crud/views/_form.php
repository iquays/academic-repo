<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php foreach ($generator->getColumnNames() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                }
            } ?>
        </div>
    </div>
    <div class="form-group box box-success box-footer">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('<i class=\'fa fa-floppy-o\'></i> Save') ?>
        : <?= $generator->generateString('<i class=\'fa fa-floppy-o\'></i> Update') ?>, ['class' => $model->isNewRecord ? 'btn bg-olive' : 'btn
        bg-blue']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
