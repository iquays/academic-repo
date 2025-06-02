<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfessionalMembership */

$this->title = Yii::t('app', 'Update Professional Membership: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Professional Membership') . ' List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="professional-membership-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </section>
</div>
