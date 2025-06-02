<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "has_decree".
 *
 * @property integer $id
 * @property integer $decree_id
 * @property integer $student_id
 * @property integer $lecturer_id
 * @property integer $sort
 *
 * @property Decree $decree
 * @property Lecturer $lecturer
 * @property Student $student
 */
class HasDecree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'has_decree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['decree_id'], 'required'],
            [['decree_id', 'student_id', 'lecturer_id', 'sort'], 'integer'],
            [['decree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Decree::className(), 'targetAttribute' => ['decree_id' => 'id']],
            [['lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['lecturer_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'decree_id' => Yii::t('app', 'Decree ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'lecturer_id' => Yii::t('app', 'Lecturer ID'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecree()
    {
        return $this->hasOne(Decree::className(), ['id' => 'decree_id']);
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
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
