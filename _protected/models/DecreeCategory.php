<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "decree_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_category
 *
 * @property Decree[] $decrees
 */
class DecreeCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'decree_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_category'], 'integer'],
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
            'parent_category' => Yii::t('app', 'Parent Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecrees()
    {
        return $this->hasMany(Decree::className(), ['decree_category_id' => 'id']);
    }

    public static function getDecreeCategoryList()
    {
        $decreeCategoryList = [];
        foreach (DecreeCategory::find()->select(['id', 'name'])->asArray()->all() as $list) {
            $decreeCategoryList[$list['id']] = $list['name'];
        }
        return $decreeCategoryList;
    }

}
