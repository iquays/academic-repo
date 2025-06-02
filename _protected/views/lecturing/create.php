<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lecturing */

$this->title = Yii::t('app', 'Add Lecturing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecturing') . ' List', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="lecturing-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </section>
</div>
