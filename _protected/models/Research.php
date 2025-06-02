<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "research".
 *
 * @property integer $id
 * @property string $title
 * @property string $funding_source
 * @property string $funding_amount
 * @property string $year
 * @property string $file_proposal
 * @property string $file_report
 *
 * @property Researching[] $researchings
 * @property string $fileProposalUrl;
 * @property string $fileReportUrl;
 */
class Research extends \yii\db\ActiveRecord
{
    public $fileProposal;
    public $fileReport;

    public $researcher;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'research';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
            ],
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['funding_amount'], 'number'],
            [['year', 'researcher'], 'safe'],
            [['title', 'funding_source'], 'string', 'max' => 255],
            [['fileProposal', 'fileReport'], 'file', 'extensions' => 'doc, docx, pdf', 'maxSize' => 2048000, 'tooBig' => Yii::t('app', 'File size limit is 2MB')],
        ];
    }

    public function getFileProposal()
    {
        return isset($this->file_proposal) ? Yii::getAlias('@uploads/research/proposal/') . $this->file_proposal : null;
    }

    public function getFileProposalUrl()
    {
        $file_proposal = empty($this->file_proposal) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/research/proposal/' . $this->file_proposal;
//        $proposal = isset($this->file_proposal) ? $this->file_proposal : 'default_user.jpg';
        return $file_proposal;
    }

    public function uploadFileProposal()
    {
        $file = UploadedFile::getInstance($this, 'fileProposal');

        if (empty($file)) {
            return false;
        }

        $this->file_proposal = Yii::$app->user->identity->profile_id . "_" . Yii::$app->security->generateRandomString(8) . "." . $file->extension;

        // the uploaded image instance
        return $file;
    }

    public function deleteFileProposal()
    {
        $file = $this->getFileProposal();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        return true;
    }

    public function getFileReport()
    {
        return isset($this->file_report) ? Yii::getAlias('@uploads/research/report/') . $this->file_report : null;
    }

    public function getFileReportUrl()
    {
        $file_report = empty($this->file_report) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/research/report/' . $this->file_report;
//        $report = isset($this->file_report) ? $this->file_report : 'default_user.jpg';
        return $file_report;
    }

    public function uploadFileReport()
    {
        $file = UploadedFile::getInstance($this, 'fileReport');

        if (empty($file)) {
            return false;
        }

        $this->file_report = Yii::$app->user->identity->profile_id . "_" . Yii::$app->security->generateRandomString(8) . "." . $file->extension;

        // the uploaded image instance
        return $file;
    }

    public function deleteFileReport()
    {
        $file = $this->getFileReport();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Research Title'),
            'funding_source' => Yii::t('app', 'Funding Source'),
            'funding_amount' => Yii::t('app', 'Funding Amount'),
            'year' => Yii::t('app', 'Year'),
            'file_proposal' => Yii::t('app', 'File Proposal'),
            'file_report' => Yii::t('app', 'File Report'),
            'fileProposal' => Yii::t('app', 'File Proposal'),
            'fileReport' => Yii::t('app', 'File Report'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearchings()
    {
        return $this->hasMany(Researching::className(), ['research_id' => 'id'])->orderBy('sort');
    }


}
