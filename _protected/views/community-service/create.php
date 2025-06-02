<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CommunityService */

$this->title = Yii::t('app', 'Add Community Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Community Service List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="community-service-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </section>
</div>
