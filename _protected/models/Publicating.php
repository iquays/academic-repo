<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "publicating".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $publication_id
 * @property integer $sort
 *
 * @property Profile $profile
 */
class Publicating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publicating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'publication_id', 'sort'], 'required'],
            [['profile_id', 'publication_id', 'sort'], 'integer'],
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
            'publication_id' => Yii::t('app', 'Publication ID'),
//            'sort' => Yii::t('app', 'Sort'),
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
