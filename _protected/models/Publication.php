<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "publication".
 *
 * @property integer $id
 * @property string $title
 * @property string $publication_name
 * @property string $volume_number
 * @property string $year
 * @property string $file_paper
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property  string $filePaperUrl
 *
 * @property Publicating[] $publicatings
 */
class Publication extends \yii\db\ActiveRecord
{
    public $writer;

    public $filePaper;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publication';
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
            [['year', 'writer'], 'safe'],
            [['title', 'publication_name', 'volume_number'], 'string', 'max' => 255],
            [['file_paper'], 'string', 'max' => 100],
            [['filePaper'], 'file', 'extensions' => 'doc, docx, pdf', 'maxSize' => 2048000, 'tooBig' => Yii::t('app', 'File size limit is 2MB')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'publication_name' => Yii::t('app', 'Publication Name'),
            'volume_number' => Yii::t('app', 'Volume/Number'),
            'year' => Yii::t('app', 'Year'),
        ];
    }

    public function getFilePaper()
    {
        return isset($this->file_paper) ? Yii::getAlias('@uploads/publication/') . $this->file_paper : null;
    }

    public function getFilePaperUrl()
    {
        $file_paper = empty($this->file_paper) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/publication/' . $this->file_paper;
//        $file_paper = isset($this->file_paper) ? $this->file_paper : 'default.jpg';
        return $file_paper;
    }

    public function uploadFile()
    {
        $file = UploadedFile::getInstance($this, 'filePaper');

        if (empty($file)) {
            return false;
        }

        $this->file_paper = Yii::$app->user->identity->profile_id . "_" . Yii::$app->security->generateRandomString(8) . "." . $file->extension;

        // the uploaded image instance
        return $file;
    }

    public function deleteFile()
    {
        $file = $this->getFilePaper();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }


        return true;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicatings()
    {
        return $this->hasMany(Publicating::className(), ['publication_id' => 'id'])->orderBy('sort');
    }

}
