<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AwardHistory */

$this->title = Yii::t('app', 'Add Award History');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Award History') . ' List', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="award-history-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
