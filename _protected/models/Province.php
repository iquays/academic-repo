<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property string $id
 * @property string $name
 *
 * @property Regency[] $regencies
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegencies()
    {
        return $this->hasMany(Regency::className(), ['province_id' => 'id']);
    }
}
