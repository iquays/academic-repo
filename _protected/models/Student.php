<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $nim
 * @property string $name
 * @property integer $profile_id
 * @property string $entry_year
 * @property integer $entry_semester
 * @property string $graduation_date
 * @property integer $status
 * @property string $financial_source
 * @property integer $toefl_score
 * @property integer $guardian_lecturer_id
 *
 * @property User $user
 * @property Studying[] $studyings
 * @property HasDecree[] $hasDecrees
 * @property Profile $profile
 * @property Lecturer $guardianLecturer
 */
class Student extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 0;

    const ENTRY_SEMESTER_ODD = 1;
    const ENTRY_SEMESTER_EVEN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
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
            [['nim', 'name', 'entry_year', 'entry_semester'], 'required'],
            [['profile_id', 'entry_semester', 'status', 'toefl_score', 'guardian_lecturer_id'], 'integer'],
            [['entry_year', 'graduation_date'], 'safe'],
            [['nim'], 'string', 'min' => 10, 'tooShort' => Yii::t('app', '{attribute} should contain 10 number'), 'max' => 10],
            [['nim'], 'integer'],
            [['nim'], 'unique'],
            [['name', 'financial_source'], 'string', 'max' => 255],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['guardian_lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['guardian_lecturer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
            'nim' => Yii::t('app', 'NIM'),
            'name' => Yii::t('app', 'Name'),
            'entry_year' => Yii::t('app', 'Entry Year'),
            'entry_semester' => Yii::t('app', 'Entry Semester'),
            'entrySemester' => Yii::t('app', 'Entry Semester'),
            'graduation_date' => Yii::t('app', 'Graduation Date'),
            'userName' => Yii::t('app', 'User Name'),
            'financial_source' => Yii::t('app', 'Financial Source'),
            'TOEFL_score' => Yii::t('app', 'TOEFL Score'),
            'guardian_lecturer_id' => Yii::t('app', 'Guardian Lecturer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['profile_id' => 'profile_id']);
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    public function getEntrySemester()
    {
        return $this->entry_semester == self::ENTRY_SEMESTER_ODD ? Yii::t('app', 'Odd') : Yii::t('app', 'Even');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasDecrees()
    {
        return $this->hasMany(HasDecree::className(), ['student_id' => 'id']);
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
    public function getGuardianLecturer()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'guardian_lecturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyings()
    {
        return $this->hasMany(Studying::className(), ['student_id' => 'id']);
    }

    public static function getEntrySemesterList()
    {
//        $entrySemesterList = [];
        $entrySemesterList[\app\models\Student::ENTRY_SEMESTER_ODD] = Yii::t('app', 'Odd');
        $entrySemesterList[\app\models\Student::ENTRY_SEMESTER_EVEN] = Yii::t('app', 'Even');
        return $entrySemesterList;
    }

    public static function getAcademicYearList()
    {
        $currentYear = date("Y", strtotime("-0 year"));
        $oldestYear = $currentYear - 5;
        do {
            $academicYearList[$currentYear] = $currentYear . '/' . ($currentYear + 1);
            $currentYear = $currentYear - 1;
        } while ($currentYear > $oldestYear);
        return $academicYearList;
    }

}
