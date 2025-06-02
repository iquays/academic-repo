<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property string $id
 * @property string $regency_id
 * @property string $name
 *
 * @property Regency $regency
 * @property Village[] $villages
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'regency_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 7],
            [['regency_id'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 255],
            [['regency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regency::className(), 'targetAttribute' => ['regency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'regency_id' => Yii::t('app', 'Regency ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegency()
    {
        return $this->hasOne(Regency::className(), ['id' => 'regency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['district_id' => 'id']);
    }
}
