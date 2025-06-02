<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studying".
 *
 * @property integer $id
 * @property integer $lecturing_id
 * @property integer $student_id
 * @property integer $mark
 * @property integer $status
 *
 * @property Lecturing $lecturing
 * @property Student $student
 */
class Studying extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studying';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturing_id', 'student_id'], 'required'],
            [['lecturing_id', 'student_id', 'mark', 'status'], 'integer'],
            [['lecturing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturing::className(), 'targetAttribute' => ['lecturing_id' => 'id']],
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
            'lecturing_id' => Yii::t('app', 'Lecturing ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'mark' => Yii::t('app', 'Mark'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturing()
    {
        return $this->hasOne(Lecturing::className(), ['id' => 'lecturing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
