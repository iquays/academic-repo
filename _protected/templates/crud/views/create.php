<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Add ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::singularize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?> . ' List', 'url' => ['index']];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Add') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <section class="content-header">
        <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
        ]) ?>
    </section>
</div>
