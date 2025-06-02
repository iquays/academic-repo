<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityService */

$this->title = Yii::t('app', 'Update Community Service: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Community Service List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="community-service-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
