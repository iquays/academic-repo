<?php
// by Syauqi

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Studying */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Studying List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="studying-view">

    <section class="content-header">
        <h1><?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a("<i class='fa fa-list'></i> " . Yii::t('app', 'Studying List'), ['index'], ['class' => 'btn bg-blue']) ?>
            </span>
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'teaching_id',
                        'student_id',
                        'mark',
                        'status',
                    ],
                ]) ?>
            </div>
        </div>

        <div class="form-group box box-success box-footer">
            <?= Html::a("<i class='fa fa-pencil-square-o'></i> " . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a("<i class='fa fa-trash-o'></i> " . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </section>

</div>
