<?php
/* @var $this yii\web\View */
use yii\bootstrap\BootstrapAsset;

//AppAsset::register($this);
BootstrapAsset::register($this);

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">

    <section class="content-header">
        <h1>Dashboard</h1>

        <!--        <p class="lead">It's lonely here</p>-->

    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?= count($profile->trainings) ?></h3>
                                <p><?= Yii::t('app', 'Training') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-certificate"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/training/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= count($profile->researches) ?></h3>
                                <p><?= Yii::t('app', 'Research') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-pencil"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/research/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3><?= count($profile->publications) ?></h3>
                                <p><?= Yii::t('app', 'Publication') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file-text-o"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/publication/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box btn-primary">
                            <div class="inner">
                                <h3><?= count($profile->scientificEvents) ?></h3>
                                <p><?= Yii::t('app', 'Scientific Event') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-flask"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/scientific-event/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <?php if (Yii::$app->user->can('lecturer')): ?>
                        <div class="col-xs-6 col-sm-4 col-md-3">
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3><?= count($profile->lecturingHistories) ?></h3>
                                    <p><?= Yii::t('app', 'Lecturing History') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <a href="<?= \yii\helpers\Url::to(['/lecturing-history/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?= count($profile->communityServices) ?></h3>
                                <p><?= Yii::t('app', 'Community Service') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-product-hunt"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/community-service/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box btn-warning">
                            <div class="inner">
                                <h3><?= count($profile->workHistories) ?></h3>
                                <p><?= Yii::t('app', 'Work History') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-building-o"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/work-history/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3><?= count($profile->awardHistories) ?></h3>
                                <p><?= Yii::t('app', 'Award History') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-trophy"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/award-history/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3><?= count($profile->professionalMemberships) ?></h3>
                                <p><?= Yii::t('app', 'Professional Membership') ?></p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-building-o"></i>
                            </div>
                            <a href="<?= \yii\helpers\Url::to(['/professional-membership/index']) ?>" class="small-box-footer"><?= Yii::t('app', 'More info') ?> <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

