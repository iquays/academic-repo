<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Update User') . ': ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">
    <section class="content-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </section>
    <section class="content">
            <?= $this->render('_form', ['user' => $user]) ?>
    </section>
</div>
