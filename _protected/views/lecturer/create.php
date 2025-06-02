<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $lecturer app\models\Lecturer */
/* @var $user \app\models\User */

$this->title = Yii::t('app', 'Add Lecturer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lecturer List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="lecturer-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'lecturer' => $lecturer,
            'user' => $user,
        ]) ?>
    </section>
</div>
