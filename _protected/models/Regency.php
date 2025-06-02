<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regency".
 *
 * @property string $id
 * @property string $province_id
 * @property string $name
 *
 * @property District[] $districts
 * @property Province $province
 */
class Regency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 4],
            [['province_id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['regency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }
    
}
