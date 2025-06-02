<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $picture
 * @property string $name
 * @property string $birth_place
 * @property string $birth_date
 * @property integer $marital_status
 * @property integer $work_status
 * @property string $institution
 * @property integer $almamater_id
 * @property integer $almamater_acreditation
 * @property string $gpa_degree
 * @property string $gpa_profession
 * @property integer $study_period
 * @property string $mandatory_workplace
 * @property string $handphone_number
 * @property string $lat
 * @property string $lng
 * @property integer $is_civitas
 * @property string $language
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property University $university
 * @property Regency $birthPlace
 *
 * @property Education[] $educations
 * @property User $user
 * @property Training[] $trainings
 * @property Research[] $researches
 * @property Publication[] $publications
 * @property ScientificEvent[] $scientificEvents
 * @property LecturingHistory[] $lecturingHistories
 * @property CommunityService[] $communityServices
 * @property WorkHistory[] $workHistories
 * @property ProfessionalMembership[] $professionalMemberships
 */
class Profile extends \yii\db\ActiveRecord
{

    const MARITAL_STATUS_SINGLE = 1; // Single
    const MARITAL_STATUS_MARRIED = 2; // Married

    const WORK_STATUS_PNS = 1; // PNS
    const WORK_STATUS_Swasta = 2; // PNS

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
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
            [['birth_date'], 'safe'],
            [['marital_status', 'work_status', 'almamater_acreditation', 'study_period', 'almamater_id', 'is_civitas'], 'integer'],
            [['gpa_degree', 'gpa_profession'], 'number', 'min' => 1, 'max' => 4],
            [['picture', 'institution'], 'string', 'max' => 100],
            [['name', 'mandatory_workplace'], 'string', 'max' => 255],
            [['birth_place'], 'string', 'max' => 4],
            [['handphone_number', 'lat', 'lng'], 'string', 'max' => 20],
            [['image'], 'file', 'extensions' => 'jpg, gif, png'],
        ];
    }


    public function getImageFile()
    {
        return isset($this->picture) ? Yii::getAlias('@uploads/profile/') . $this->picture : null;
    }

    public function getImageFileThumbnail()
    {
        return isset($this->picture) ? Yii::getAlias('@uploads/profile/thumbnail/') . $this->picture : null;
    }

    public function getImageUrl()
    {
        $picture = isset($this->picture) ? $this->picture : 'default_user.jpg';
        return Yii::$app->UrlManager->baseUrl . '/uploads/profile/' . $picture;
    }

    public function getImageUrlThumbnail()
    {
        $picture = isset($this->picture) ? $this->picture : 'default_user.jpg';
        return Yii::$app->UrlManager->baseUrl . '/uploads/profile/thumbnail/' . $picture;
    }

    public function uploadImage()
    {
        $image = UploadedFile::getInstance($this, 'image');

        if (empty($image)) {
            return false;
        }

        $this->picture = Yii::$app->user->identity->profile_id . "_" . Yii::$app->user->identity->username . "_" . Yii::$app->security->generateRandomString(8) . "." . $image->extension;

        // the uploaded image instance
        return $image;
    }

    public function deleteImage()
    {
        $file = $this->getImageFile();
        $fileThumbnail = $this->getImageFileThumbnail();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        if (!unlink($fileThumbnail)) {
            return false;
        }

        $this->picture = null;

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Picture'),
            'picture' => Yii::t('app', 'Picture'),
            'name' => Yii::t('app', 'Name'),
            'birth_place' => Yii::t('app', 'Birth Place'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'marital_status' => Yii::t('app', 'Marital Status'),
            'work_status' => Yii::t('app', 'Work Status'),
            'institution' => Yii::t('app', 'Institution'),
            'almamater_id' => Yii::t('app', 'Almamater'),
            'almamater_acreditation' => Yii::t('app', 'Almamater Acreditation'),
            'gpa_degree' => Yii::t('app', 'GPA Degree'),
            'gpa_profession' => Yii::t('app', 'GPA Profession'),
            'study_period' => Yii::t('app', 'Study Period'),
            'mandatory_workplace' => Yii::t('app', 'Mandatory Workplace'),
            'handphone_number' => Yii::t('app', 'Handphone Number'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'almamater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBirthPlace()
    {
        return $this->hasOne(Regency::className(), ['id' => 'birth_place']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::className(), ['profile_id' => 'id'])->where(['is not', 'education.name', null])->orderBy(['education.level' => SORT_ASC]);
    }

    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['profile_id' => 'id'])->orderBy(['training.end_date' => SORT_DESC]);
    }

    public function getResearches()
    {
        return $this->hasMany(Research::className(), ['id' => 'research_id'])->viaTable('researching', ['profile_id' => 'id'])->orderBy(['research.year' => SORT_DESC]);
    }

    public function getPublications()
    {
        return $this->hasMany(Publication::className(), ['id' => 'publication_id'])->viaTable('publicating', ['profile_id' => 'id'])->orderBy(['publication.year' => SORT_DESC]);
    }

    public function getScientificEvents()
    {
        return $this->hasMany(ScientificEvent::className(), ['profile_id' => 'id'])->orderBy(['scientific_event.date' => SORT_DESC]);
    }

    public function getLecturingHistories()
    {
        return $this->hasMany(LecturingHistory::className(), ['profile_id' => 'id'])->orderBy(['lecturing_history.year' => SORT_DESC]);
    }

    public function getCommunityServices()
    {
        return $this->hasMany(CommunityService::className(), ['id' => 'community_service_id'])->viaTable('community_servicing', ['profile_id' => 'id'])->orderBy(['community_service.date' => SORT_DESC]);
    }

    public function getWorkHistories()
    {
        return $this->hasMany(WorkHistory::className(), ['profile_id' => 'id'])->orderBy([new \yii\db\Expression('work_history.end_date IS NULL DESC')]);
    }

    public function getAwardHistories()
    {
        return $this->hasMany(AwardHistory::className(), ['profile_id' => 'id'])->orderBy(['award_history.date' => SORT_DESC]);
    }

    public function getProfessionalMemberships()
    {
        return $this->hasMany(ProfessionalMembership::className(), ['profile_id' => 'id'])->orderBy(['professional_membership.year' => SORT_DESC]);
    }


    public static function getMaritalStatusList()
    {
//        $maritalStatusList = [];
        $maritalStatusList[self::MARITAL_STATUS_SINGLE] = Yii::t('app', 'Single');
        $maritalStatusList[self::MARITAL_STATUS_MARRIED] = Yii::t('app', 'Married');
        return $maritalStatusList;

    }

    public static function getWorkStatusList()
    {
//        $workStatusList = [];
        $workStatusList[self::WORK_STATUS_PNS] = Yii::t('app', 'Goverment Employee');
        $workStatusList[self::WORK_STATUS_Swasta] = Yii::t('app', 'Private Employee');
        return $workStatusList;
    }

}

