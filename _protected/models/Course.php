<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $sks
 *
 * @property Lecturing[] $lecturings
 * @property LecturingHistory[] $lecturingHistories
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sks', 'code'], 'required'],
            ['code', 'unique'],
            [['sks'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', "Courses's Code"),
            'name' => Yii::t('app', "Course's Name"),
            'sks' => Yii::t('app', 'Sks'),
        ];
    }

    public static function getSksList()
    {
        $sksList = [];
        $sksList[1] = '1';
        $sksList[2] = '2';
        $sksList[3] = '3';
        $sksList[4] = '4';
        $sksList[5] = '5';
        $sksList[6] = '6';
        return $sksList;
    }

    public static function getCourseList()
    {
        $courseList = [];
        foreach (Course::find()->select(['id', 'name'])->asArray()->all() as $course) {
            $courseList[$course['id']] = $course['name'];
        }

        return $courseList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturings()
    {
        return $this->hasMany(Lecturing::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturingHistories()
    {
        return $this->hasMany(LecturingHistory::className(), ['course_id' => 'id']);
    }

}
