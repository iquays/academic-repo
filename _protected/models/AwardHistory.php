<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "award_history".
 *
 * @property integer $id
 * @property string $title
 * @property string $grantor
 * @property string $certificate
 * @property string $date
 * @property integer $profile_id
 *
 * @property Profile $profile
 */
class AwardHistory extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'award_history';
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
            [['title', 'grantor', 'profile_id'], 'required'],
            [['date'], 'safe'],
            [['profile_id'], 'integer'],
            [['title', 'grantor'], 'string', 'max' => 255],
            [['certificate'], 'string', 'max' => 100],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['file'], 'file', 'extensions' => 'jpg, gif, png, pdf', 'maxSize' => 2048000, 'tooBig' => Yii::t('app', 'File size limit is 2MB')],
        ];
    }

    public function getFile()
    {
        return isset($this->certificate) ? Yii::getAlias('@uploads/award/') . $this->certificate : null;
    }

    public function getFileUrl()
    {
        $theUrl = empty($this->certificate) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/award/' . $this->certificate;
        return $theUrl;
    }

    public function uploadFile()
    {
        $file = UploadedFile::getInstance($this, 'file');

        if (empty($file)) {
            return false;
        }

        $this->certificate = Yii::$app->user->identity->profile_id . "_" . Yii::$app->security->generateRandomString(8) . "." . $file->extension;

        // the uploaded image instance
        return $file;
    }

    public function deleteFile()
    {
        $file = $this->getFile();

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
//            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Award Title'),
            'grantor' => Yii::t('app', 'Award Grantor'),
            'certificate' => Yii::t('app', 'Certificate'),
            'date' => Yii::t('app', 'Date'),
//            'profile_id' => Yii::t('app', 'Profile ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
