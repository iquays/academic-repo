<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "training".
 *
 * @property integer $id
 * @property string $name
 * @property string $organizer
 * @property string $city_id
 * @property string $start_date
 * @property string $end_date
 * @property string $certificate
 * @property integer $profile_id
 *
 * @property Profile $profile
 * @property Regency $city
 *
 * @property string $fileUrl
 */
class Training extends \yii\db\ActiveRecord
{


    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'training';
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
            [['name'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['profile_id'], 'integer'],
            [['name', 'organizer'], 'string', 'max' => 255],
            [['city_id'], 'string', 'max' => 4],
            [['certificate'], 'string', 'max' => 100],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['file'], 'file', 'extensions' => 'jpg, gif, png, pdf', 'maxSize' => 2048000, 'tooBig' => Yii::t('app', 'File size limit is 2MB')],
        ];
    }


    public function getFile()
    {
        return isset($this->certificate) ? Yii::getAlias('@uploads/training/') . $this->certificate : null;
    }

    public function getFileUrl()
    {
        $theUrl = empty($this->certificate) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/training/' . $this->certificate;
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
            'name' => Yii::t('app', 'Name of Training'),
            'organizer' => Yii::t('app', 'Organizer'),
            'city_id' => Yii::t('app', 'Place'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'certificate' => Yii::t('app', 'Certificate'),
            'profile_id' => Yii::t('app', 'Profile ID'),
            'file' => Yii::t('app', 'Certificate'),
            'cityName' => Yii::t('app', 'City Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Regency::className(), ['id' => 'city_id']);
    }

    public function getCityName()
    {
        return $this->city->name;
    }

}
