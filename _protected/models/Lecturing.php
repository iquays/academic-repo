<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Lecturing".
 *
 * @property integer $id
 * @property integer $lecturer_id
 * @property integer $course_id
 * @property string $year
 * @property integer $semester
 * @property integer $status
 *
 * @property Studying[] $studyings
 * @property Lecturer $lecturer
 * @property Course $course
 */
class Lecturing extends \yii\db\ActiveRecord
{
    public $student;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecturing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturer_id', 'course_id', 'year', 'semester'], 'required'],
            [['lecturer_id', 'course_id', 'semester', 'status'], 'integer'],
            [['year', 'student'], 'safe'],
            [['lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['lecturer_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
//            'lecturer_id' => Yii::t('app', 'Lecturer ID'),
            'lecturerName' => Yii::t('app', 'Lecturer Name'),
//            'course_id' => Yii::t('app', 'Course ID'),
            'courseName' => Yii::t('app', 'Course Name'),
            'year' => Yii::t('app', 'Academic Year'),
            'semester' => Yii::t('app', 'Semester'),
            'status' => Yii::t('app', 'Status'),
            'semesterName' => Yii::t('app', 'Semester'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyings()
    {
        return $this->hasMany(Studying::className(), ['lecturing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturer()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getLecturerName()
    {
        return $this->lecturer->name;
    }

    public function getCourseName()
    {
        return $this->course->name;
    }

    public function getSemesterName()
    {
        return $this->semester == '1' ? Yii::t('app', 'Odd') : Yii::t('app', 'Even');
    }

    public static function getSemesterList()
    {
        $semesterList['1'] = Yii::t('app', 'Odd');
        $semesterList['2'] = Yii::t('app', 'Even');
        return $semesterList;
    }

    public static function getAcademicYearList()
    {
        $currentYear = date("Y", strtotime("-0 year"));
        $oldestYear = $currentYear - 3;
        do {
            $academicYearList[$currentYear] = $currentYear . '/' . ($currentYear + 1);
            $currentYear = $currentYear - 1;
        } while ($currentYear > $oldestYear);
        return $academicYearList;
    }


}
