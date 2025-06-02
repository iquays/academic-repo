<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $student app\models\Student */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Update Student: ') . $student->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $student->name, 'url' => ['view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="student-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
        <?= $this->render('_form', [
            'student' => $student,
            'user' => $user,
        ]) ?>
    </section>
</div>
