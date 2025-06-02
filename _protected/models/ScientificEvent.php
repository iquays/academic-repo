<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scientific_event".
 *
 * @property integer $id
 * @property string $name
 * @property string $organizer
 * @property string $city_id
 * @property string $date
 * @property integer $position
 * @property integer $profile_id
 *
 * @property Regency $city
 */
class ScientificEvent extends \yii\db\ActiveRecord
{
    const POSITION_COMMITTEE = 1;
    const POSITION_PARTICIPANT = 2;
    const POSITION_SPEAKER = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scientific_event';
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
            [['name'], 'required'],
            [['date'], 'safe'],
            [['position', 'profile_id'], 'integer'],
            [['name', 'organizer'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Event Name'),
            'organizer' => Yii::t('app', 'Organizer'),
            'city_id' => Yii::t('app', 'City'),
            'date' => Yii::t('app', 'Date'),
            'position' => Yii::t('app', 'Position'),
            'cityName' => Yii::t('app', 'City Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Regency::className(), ['id' => 'city_id']);
    }

    public static function getPositionList()
    {
        $positionsList = [];
        $positionsList[ScientificEvent::POSITION_COMMITTEE] = Yii::t('app', 'Committee');
        $positionsList[ScientificEvent::POSITION_PARTICIPANT] = Yii::t('app', 'Participant');
        $positionsList[ScientificEvent::POSITION_SPEAKER] = Yii::t('app', 'Speaker');
        return $positionsList;
    }

    public function getCityName()
    {
        return $this->city->name;
    }
}
