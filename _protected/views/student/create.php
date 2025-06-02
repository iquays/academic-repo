<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $student app\models\Student */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Add Student');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>
<div class="student-create">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'student' => $student,
            'user' => $user
        ]) ?>
    </section>
</div>
