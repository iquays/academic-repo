<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>
// by Syauqi

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List of ') . <?= $generator->generateString(Inflector::singularize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <section class="content-header">
        <h1><?= "<?= " ?>Html::encode($this->title) ?>
            <span class="pull-right">
                <?= "<?= " ?>Html::a(<?= $generator->generateString('<i class=\'fa fa-list\'></i> List of ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        echo "            '" . $name . "',\n";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
                ?>
                ],
                ]) ?>
            </div>
        </div>

        <div class="form-group box box-success box-footer">
            <?= "<?= " ?>Html::a(<?= $generator->generateString('<i class=\'fa fa-pencil-square-o\'></i> Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn bg-blue']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('<i class=\'fa fa-trash-o\'></i> Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
            'method' => 'post',
            ],
            ]) ?>
        </div>
    </section>

</div>
