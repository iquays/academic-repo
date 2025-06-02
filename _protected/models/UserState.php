<?php

namespace app\models;

/**
 * This is the model class for table "user_state".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $value
 */
class UserState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'value'], 'required'],
            [['user_id', 'value'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    
}
