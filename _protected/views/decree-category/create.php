<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DecreeCategory */

$this->title = Yii::t('app', 'Add Decree Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Decree Category List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="decree-category-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
