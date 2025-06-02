<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_history".
 *
 * @property integer $id
 * @property string $title
 * @property string $workplace
 * @property string $city_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $profile_id
 *
 * @property Profile $profile
 * @property Regency $city
 */
class WorkHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_history';
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
            [['workplace', 'profile_id'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['profile_id'], 'integer'],
            [['title', 'workplace'], 'string', 'max' => 255],
            [['city_id'], 'string', 'max' => 4],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regency::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Job Title'),
            'workplace' => Yii::t('app', 'Workplace'),
            'city_id' => Yii::t('app', 'City'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'profile_id' => Yii::t('app', 'Profile ID'),
            'cityName' => Yii::t('app', 'City Name')
        ];
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
    public function getCity()
    {
        return $this->hasOne(Regency::className(), ['id' => 'city_id']);
    }

    public function getCityName()
    {
        return $this->city->name;
    }
}
