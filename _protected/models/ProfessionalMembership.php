<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "professional_membership".
 *
 * @property integer $id
 * @property string $name
 * @property string $position
 * @property string $year
 * @property integer $profile_id
 *
 * @property Profile $profile
 */
class ProfessionalMembership extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_membership';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'profile_id'], 'required'],
            [['year'], 'safe'],
            [['profile_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['position'], 'string', 'max' => 100],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Organization Name'),
            'position' => Yii::t('app', 'Position'),
            'year' => Yii::t('app', 'Year'),
//            'profile_id' => Yii::t('app', 'Profile ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
