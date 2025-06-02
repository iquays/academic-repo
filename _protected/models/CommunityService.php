<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "community_service".
 *
 * @property integer $id
 * @property string $title
 * @property string $place
 * @property string $city_id
 * @property string $funding_source
 * @property string $funding_amount
 * @property string $date
 *
 * @property Regency $city
 * @property CommunityServicing[] $communityServicings
 */
class CommunityService extends \yii\db\ActiveRecord
{

    public $servicer;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community_service';
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
            [['title'], 'required'],
            [['funding_amount'], 'number'],
            [['date', 'servicer'], 'safe'],
            [['title', 'place', 'funding_source'], 'string', 'max' => 255],
            [['city_id'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'place' => Yii::t('app', 'Place'),
            'city_id' => Yii::t('app', 'City'),
            'cityName' => Yii::t('app', 'City Name'),
            'funding_source' => Yii::t('app', 'Funding Source'),
            'funding_amount' => Yii::t('app', 'Funding Amount'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Regency::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunityServicings()
    {
        return $this->hasMany(CommunityServicing::className(), ['community_service_id' => 'id'])->orderBy('sort');
    }

    public function getCityName()
    {
        return $this->city->name;
    }
}
