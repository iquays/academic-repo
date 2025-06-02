<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = Yii::t('app', 'Curriculum Vitae');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .columnCurrency {
        text-align: right;
        width: 140px;
    }
</style>
<div class="profile-view">

    <section class="content-header">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <br/>
        <?= Html::img($profile->getImageUrlThumbnail(), ['class' => 'profile-user-img img-responsive img-circle', 'alt' => Html::encode($profile->name), 'title' => Html::encode($profile->name)]) ?>
        <h3 class="profile-username text-center"><?= Html::encode($profile->name) ?></h3>
    </section>

    <section class="content">
        <!--Profile-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> <?= Yii::t('app', 'Personal Detail') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['update'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'name') ?></td>
                        <td><?= Html::encode($profile->name) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'birth_place') ?></td>
                        <td><?= empty($profile->birth_place) ? null : Html::encode($profile->birthPlace->name) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'birth_date') ?></td>
                        <td><?= Yii::$app->formatter->asDate($profile->birth_date, 'long') ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'institution') ?></td>
                        <td><?= Html::encode($profile->institution) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'almamater_id') ?></td>
                        <td><?= empty($profile->almamater_id) ? null : Html::encode($profile->university->name) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'gpa_degree') ?></td>
                        <td><?= Yii::$app->formatter->asDecimal($profile->gpa_degree, 2) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'gpa_profession') ?></td>
                        <td><?= Yii::$app->formatter->asDecimal($profile->gpa_profession, 2) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'handphone_number') ?></td>
                        <td><?= Html::encode($profile->handphone_number) ?></td>
                    </tr>
                    <tr>
                        <td class="columnLabel"><?= Html::activeLabel($profile, 'mandatory_workplace') ?></td>
                        <td><?= Html::encode($profile->mandatory_workplace) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!--End of Profile-->

        <!--Education -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bank"></i> <?= Yii::t('app', 'Education') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['education/tabularform'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->educations) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnLevel"><?= Yii::t('app', 'Level') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Name of School') ?></th>
                            <th colspan="4"><?= Yii::t('app', 'City') ?></th>
                            <th class="columnYear"><?= Yii::t('app', 'Graduation Year') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->educations as $education): ?>
                            <tr>
                                <td class="columnLevel"><?= $education->levelName ?></td>
                                <td colspan="10"><?= Html::encode($education->name) ?></td>
                                <td colspan="4"><?= empty($education->city_id) ? null : $education->city->name ?></td>
                                <td class="columnYear"><?= $education->graduation_year ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Education-->

        <!--Training -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-certificate"></i> <?= Yii::t('app', 'Training') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['training/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->trainings) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Name of Training') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Organizer') ?></th>
                            <th colspan="6"><?= Yii::t('app', 'Place') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'Start Date') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'End Date') ?></th>
                            <th class="columnDocument"><?= Yii::t('app', 'Document') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->trainings as $i => $training): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($training->name) ?></td>
                                <td colspan="10"><?= Html::encode($training->organizer) ?></td>
                                <td colspan="6"><?= empty($training->city_id) ? null : $training->city->name ?></td>
                                <td class="columnDate"><?= Yii::$app->formatter->asDate($training->start_date, 'long') ?></td>
                                <td class="columnDate"><?= Yii::$app->formatter->asDate($training->end_date, 'long') ?></td>
                                <td class="columnDocument">
                                    <?php
                                    if (!empty($training->fileUrl)) {
                                        echo Html::a(
                                            '<i class="fa fa-download"></i>',
                                            $training->fileUrl,
                                            [
                                                'class' => 'btn bg-green btn-xs',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download ' . $training->getAttributeLabel('certificate')
                                            ]
                                        );
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Training-->

        <!--Research-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pencil"></i> <?= Yii::t('app', 'Research') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['research/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->researches) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Research Title') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Funding Source') ?></th>
                            <th class="columnCurrency"><?= Yii::t('app', 'Funding Amount') ?></th>
                            <th class="columnYear"><?= Yii::t('app', 'Year') ?></th>
                            <th class="columnDocument"><?= Yii::t('app', 'Document') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->researches as $i => $research): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($research->title) ?></td>
                                <td colspan="10"><?= Html::encode($research->funding_source) ?></td>
                                <td class="columnCurrency"><?= Yii::$app->formatter->asCurrency($research->funding_amount) ?></td>
                                <td class="columnYear"><?= $research->year ?></td>
                                <td class="columnDocument">
                                    <?php
                                    if (!empty($research->fileProposalUrl)) {
                                        echo Html::a(
                                            '<i class="fa fa-download"></i>',
                                            $research->fileProposalUrl,
                                            [
                                                'class' => 'btn bg-green btn-xs',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download ' . $research->getAttributeLabel('file_proposal')
                                            ]
                                        );
                                    }
                                    //                                    echo " ";
                                    if (!empty($research->fileReportUrl)) {
                                        echo Html::a(
                                            '<i class="fa fa-download"></i>',
                                            $research->fileReportUrl,
                                            [
                                                'class' => 'btn bg-orange btn-xs',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download ' . $research->getAttributeLabel('file_report')
                                            ]
                                        );
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Research-->

        <!--Publication-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text-o"></i> <?= Yii::t('app', 'Publication') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['publication/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->publications) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Title') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Publication Name') ?></th>
                            <th colspan="5"><?= Yii::t('app', 'Volume/Number') ?></th>
                            <th class="columnYear"><?= Yii::t('app', 'Year') ?></th>
                            <th class="columnDocument"><?= Yii::t('app', 'Document') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->publications as $i => $publication): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($publication->title) ?></td>
                                <td colspan="10"><?= Html::encode($publication->publication_name) ?></td>
                                <td colspan="5"><?= Html::encode($publication->volume_number) ?></td>
                                <td class="columnYear"><?= $publication->year ?></td>
                                <td class="columnDocument">
                                    <?php
                                    if (!empty($publication->filePaperUrl)) {
                                        echo Html::a(
                                            '<i class="fa fa-download"></i>',
                                            $publication->filePaperUrl,
                                            [
                                                'class' => 'btn bg-green btn-xs',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download ' . $publication->getAttributeLabel('file_paper')
                                            ]
                                        );
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Publication-->

        <!--Scientific Event-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-flask"></i> <?= Yii::t('app', 'Scientific Event') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['scientific-event/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->scientificEvents) > 0): ?>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Name') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Organizer') ?></th>
                            <th colspan="5"><?= Yii::t('app', 'City') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'Date') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->scientificEvents as $i => $scientificEvent): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($scientificEvent->name) ?></td>
                                <td colspan="10"><?= Html::encode($scientificEvent->organizer) ?></td>
                                <td colspan="5"><?= $scientificEvent->city->name ?></td>
                                <td class="columnDate"><?= Yii::$app->formatter->asDate($scientificEvent->date, 'long') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Scientific Event-->

        <!--Lecturing History-->
        <?php if (Yii::$app->user->can('lecturer')): ?>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-briefcase"></i> <?= Yii::t('app', 'Lecturing History') ?></h3>
                    <div class="box-tools pull-right">
                        <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                            <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['lecturing-history/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                        <?php endif; ?>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body box-profile">
                    <?php if (count($profile->lecturingHistories) > 0): ?>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                                <th class="columnLevel"><?= Yii::t('app', 'Level') ?></th>
                                <th colspan="10"><?= Yii::t('app', "Course's Name") ?></th>
                                <th colspan="5"><?= Yii::t('app', 'Institution') ?></th>
                                <th class="columnYear"><?= Yii::t('app', 'Year') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($profile->lecturingHistories as $i => $lecturingHistory): ?>
                                <tr>
                                    <td class="columnNumber"><?= $i + 1 ?></td>
                                    <td class="columnLevel"><?= $lecturingHistory->levelName ?></td>
                                    <td colspan="10"><?= Html::encode($lecturingHistory->course->name) ?></td>
                                    <td colspan="5"><?= Html::encode($lecturingHistory->institution) ?></td>
                                    <td class="columnYear"><?= $lecturingHistory->year ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p><?= Yii::t('app', 'No data') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <!--End of Lecturing History-->

        <!--Community Service-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-product-hunt"></i> <?= Yii::t('app', 'Community Service') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['community-service/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->communityServices) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Title') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Place') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Funding Source') ?></th>
                            <th class="columnCurrency"><?= Yii::t('app', 'Funding Amount') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'Date') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->communityServices as $i => $communityService): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($communityService->title) ?></td>
                                <td colspan="10"><?= Html::encode($communityService->place) . ", " . $communityService->city->name ?></td>
                                <td colspan="10"><?= $communityService->funding_source ?></td>
                                <td class="columnCurrency"><?= Yii::$app->formatter->asCurrency($communityService->funding_amount) ?></td>
                                <td class="columnYear"><?= Yii::$app->formatter->asDate($communityService->date, 'long') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Community Service-->

        <!--Work History-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-building-o"></i> <?= Yii::t('app', 'Work History') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['work-history/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->workHistories) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Job Title') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Workplace') ?></th>
                            <th colspan="5"><?= Yii::t('app', 'City') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'Start Date') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'End Date') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->workHistories as $i => $workHistory): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($workHistory->title) ?></td>
                                <td colspan="10"><?= Html::encode($workHistory->workplace) ?></td>
                                <td colspan="5"><?= $workHistory->city->name ?></td>
                                <td class="columnDate"><?= Yii::$app->formatter->asDate($workHistory->start_date, 'long') ?></td>
                                <td class="columnDate"><?= empty($workHistory->end_date) ? Yii::t('app', 'Now') : Yii::$app->formatter->asDate($workHistory->end_date, 'long') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Work History-->

        <!--Award History-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-trophy"></i> <?= Yii::t('app', 'Award History') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['award-history/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->awardHistories) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Award Title') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Award Grantor') ?></th>
                            <th class="columnDate"><?= Yii::t('app', 'Date') ?></th>
                            <th class="columnDocument"><?= Yii::t('app', 'Document') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->awardHistories as $i => $awardHistory): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($awardHistory->title) ?></td>
                                <td colspan="10"><?= Html::encode($awardHistory->grantor) ?></td>
                                <td class="columnDate"><?= Yii::$app->formatter->asDate($awardHistory->date, 'long') ?></td>
                                <td class="columnDocument">
                                    <?php
                                    if (!empty($awardHistory->fileUrl)) {
                                        echo Html::a(
                                            '<i class="fa fa-download"></i>',
                                            $awardHistory->fileUrl,
                                            [
                                                'class' => 'btn bg-green btn-xs',
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Download ' . $awardHistory->getAttributeLabel('certificate')
                                            ]
                                        );
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Award History-->

        <!--Professional Membership-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user-md"></i> <?= Yii::t('app', 'Professional Membership') ?></h3>
                <div class="box-tools pull-right">
                    <?php if (Yii::$app->user->identity->profile_id == $profile->id): ?>
                        <span><?= Html::a("<i class='fa fa-pencil-square-o'></i>  " . Yii::t('app', 'Update'), ['award-history/index'], ['class' => 'btn bg-blue btn-xs']) ?></span>
                    <?php endif; ?>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body box-profile">
                <?php if (count($profile->professionalMemberships) > 0): ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr>
                            <th class="columnNumber"><?= Yii::t('app', 'No') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Organization Name') ?></th>
                            <th colspan="10"><?= Yii::t('app', 'Posisi') ?></th>
                            <th class="columnYear"><?= Yii::t('app', 'Year') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($profile->professionalMemberships as $i => $professionalMembership): ?>
                            <tr>
                                <td class="columnNumber"><?= $i + 1 ?></td>
                                <td colspan="10"><?= Html::encode($professionalMembership->name) ?></td>
                                <td colspan="10"><?= Html::encode($professionalMembership->position) ?></td>
                                <td class="columnYear"><?= $professionalMembership->year ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><?= Yii::t('app', 'No data') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!--End of Professional Membership-->
    </section>

</div>
