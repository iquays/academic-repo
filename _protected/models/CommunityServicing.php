<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "community_servicing".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $community_service_id
 * @property integer $sort
 *
 * @property CommunityService $communityService
 * @property Profile $profile
 */
class CommunityServicing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community_servicing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'community_service_id', 'sort'], 'required'],
            [['profile_id', 'community_service_id', 'sort'], 'integer'],
            [['community_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommunityService::className(), 'targetAttribute' => ['community_service_id' => 'id']],
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
            'community_service_id' => Yii::t('app', 'Community Service ID'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunityService()
    {
        return $this->hasOne(CommunityService::className(), ['id' => 'community_service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
