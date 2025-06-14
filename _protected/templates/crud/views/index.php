<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::singularize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <section class="content-header">
        <h1><?= "<?= " ?>Html::encode($this->title) ?>
            <?php if (!empty($generator->searchModelClass)): ?>
                <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php endif; ?>
            <span class="pull-right">
                <?= "<?= " ?>Html::a(<?= $generator->generateString('<i class=\'fa fa-plus\'></i>  Add ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn bg-olive']) ?>
            </span>
        </h1>
    </section>
    <?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <?php if ($generator->indexWidgetType === 'grid'): ?>
                    <?= "<?= " ?>GridView::widget([
                    'dataProvider' => $dataProvider,
                    <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
                    [
                    'class' => 'kartik\grid\SerialColumn',
                    'header' => 'No',
                    'vAlign' => GridView::ALIGN_TOP
                    ],

                    <?php
                    $count = 0;
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                        foreach ($generator->getColumnNames() as $name) {
                            if (++$count < 6) {
                                echo "            '" . $name . "',\n";
                            } else {
                                echo "            // '" . $name . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if (++$count < 6) {
                                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            } else {
                                echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                        }
                    }
                    ?>

                    [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Menu',
                    'vAlign' => GridView::ALIGN_TOP
                    ],


                    ],
                    ]); ?>
                <?php else: ?>
                    <?= "<?= " ?>ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                    return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                    },
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
</div>
