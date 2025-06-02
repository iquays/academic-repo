<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "researching".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $research_id
 * @property integer $sort
 *
 * @property Research $research
 * @property Profile $profile
 */
class Researching extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'researching';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['profile_id', 'research_id', 'order'], 'required'],
//            [['profile_id', 'research_id', 'order'], 'integer'],
            [['research_id'], 'exist', 'skipOnError' => true, 'targetClass' => Research::className(), 'targetAttribute' => ['research_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile_id' => Yii::t('app', 'Profile ID'),
            'research_id' => Yii::t('app', 'Research ID'),
//            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearch()
    {
        return $this->hasOne(Research::className(), ['id' => 'research_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }


}
