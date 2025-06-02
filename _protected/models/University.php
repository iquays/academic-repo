<?php

namespace app\models;

/**
 * This is the model class for table "university".
 *
 * @property integer $id
 * @property string $name
 * @property string $city
 *
 * @property Profile[] $profiles
 */
class University extends \yii\db\ActiveRecord
{
    const ACCREDITATION_LEVEL_A = 1; // A
    const ACCREDITATION_LEVEL_B = 2; // B
    const ACCREDITATION_LEVEL_C = 3; // C

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['city'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'city' => 'City',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['almamater' => 'id']);
    }

    public static function getAccreditationLevelList()
    {
        $accreditationLevelList = [];
        $accreditationLevelList[University::ACCREDITATION_LEVEL_A] = 'A';
        $accreditationLevelList[University::ACCREDITATION_LEVEL_B] = 'B';
        $accreditationLevelList[University::ACCREDITATION_LEVEL_C] = 'C';
        return $accreditationLevelList;
    }
}
