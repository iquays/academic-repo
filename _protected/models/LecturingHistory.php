<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lecturing_history".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $level
 * @property string $institution
 * @property string $year
 * @property integer $profile_id
 *
 * @property Course $course
 * @property string $courseName
 */
class LecturingHistory extends \yii\db\ActiveRecord
{
    const LEVEL_S1 = 1;
    const LEVEL_S2 = 2;
    const LEVEL_S3 = 3;
    const LEVEL_PPDS1 = 21;
    const LEVEL_PPDS2 = 22;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecturing_history';
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
            [['course_id', 'level', 'institution', 'year', 'profile_id'], 'required'],
            [['course_id', 'level'], 'integer'],
            [['year'], 'safe'],
            [['institution'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'Id'),
            'course_id' => Yii::t('app', "Course's Name"),
            'level' => Yii::t('app', 'Level'),
            'levelName' => Yii::t('app', 'Level'),
            'institution' => Yii::t('app', 'Institution'),
            'year' => Yii::t('app', 'Year'),
            'courseName' => Yii::t('app', 'Course Name'),
        ];
    }

    public static function getLevelList()
    {
        $levelList = [];
        $levelList[self::LEVEL_S1] = Yii::t('app', 'Degree');
        $levelList[self::LEVEL_S2] = Yii::t('app', 'Master');
        $levelList[self::LEVEL_S3] = Yii::t('app', 'Doctoral');
        $levelList[self::LEVEL_PPDS1] = Yii::t('app', 'PPDS1');
        $levelList[self::LEVEL_PPDS2] = Yii::t('app', 'PPDS2');
        return $levelList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getCourseName()
    {
        return $this->course->name;
    }

    public function getLevelName()
    {
        switch ($this->level) {
            case self::LEVEL_S1:
                return "S1";
                break;
            case self::LEVEL_S2:
                return "S2";
                break;
            case self::LEVEL_S3:
                return "S3";
                break;
            case self::LEVEL_PPDS1:
                return "PPDS1";
                break;
            case self::LEVEL_PPDS2:
                return "PPDS2";
                break;
        }
    }
}
