<?php

namespace app\models;

use kartik\builder\TabularForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use Yii;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * This is the model class for table "education".
 *
 * @property integer $id
 * @property integer $level
 * @property string $name
 * @property string $city_id
 * @property string $graduation_year
 * @property integer $profile_id
 *
 * @property Profile $profile
 * @property Regency $city
 */
class Education extends \yii\db\ActiveRecord
{
    const EDUCATION_LEVEL_SD = 1;
    const EDUCATION_LEVEL_SMP = 2;
    const EDUCATION_LEVEL_SMA = 3;
    const EDUCATION_LEVEL_S1 = 4;
    const EDUCATION_LEVEL_S2 = 5;
    const EDUCATION_LEVEL_S3 = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education';
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
            [['level'], 'required'],
            [['level', 'profile_id'], 'integer'],
            [['graduation_year'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['city_id'], 'string', 'max' => 4],
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
            'level' => Yii::t('app', 'Level'),
            'levelName' => Yii::t('app', 'Level'),
            'name' => Yii::t('app', 'Name'),
            'city_id' => Yii::t('app', 'City'),
            'graduation_year' => Yii::t('app', 'Graduation Year'),
            'profile_id' => Yii::t('app', 'Profile ID'),
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
//        return $this->hasOne(Regency::className(), ['id' => 'city_id'])->name;
    }

    public function getFormAttribs()
    {
        return [
            // primary key column
            'id' => [ // primary key attribute
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
//            'level' => [
//                'type' => TabularForm::INPUT_DROPDOWN_LIST,
//                'items' => Education::getEducationLevelList(),
//                'columnOptions' => ['width' => '100px', 'hAlign' => 'center'],
//            ],
            'levelName' => [
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['width' => '100px', 'hAlign' => 'center'],
            ],
            'name' => ['type' => TabularForm::INPUT_TEXT],
            'city_id' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => Select2::className(),
                'options' => function ($model) {
                    $cityName = empty($model->city_id) ? '' : $model->city->name;
                    return [
                        'initValueText' => $cityName,
                        'theme' => Select2::THEME_DEFAULT,
                        'options' => ['placeholder' => Yii::t('app', 'Choose Regency...')],
                        'pluginOptions' => [
                            'minimumInputLength' => 3,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['regency/searchajax']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(regency) { return regency.text; }'),
                            'templateSelection' => new JsExpression('function (regency) { return regency.text; }'),
                        ],
                    ];

                },

                'columnOptions' => ['width' => '230px'],
            ],
            'graduation_year' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => DatePicker::className(),
                'columnOptions' => ['width' => '130px', 'hAlign' => 'center'],
                'options' => [
                    'options' => ['class' => 'text-center'],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'startView' => 2,
                        'minViewMode' => 'years',
                        'defaultViewDate' => [
                            'year' => '2005',
                        ],
                        'autoclose' => true,
                        'format' => 'yyyy',
                    ],
                ],
            ],
        ];
    }

    public static function getEducationLevelList()
    {
        $educationLevelList = [];
        $educationLevelList[self::EDUCATION_LEVEL_SD] = 'SD';
        $educationLevelList[self::EDUCATION_LEVEL_SMP] = 'SMP';
        $educationLevelList[self::EDUCATION_LEVEL_SMA] = 'SMA';
        $educationLevelList[self::EDUCATION_LEVEL_S1] = 'S1';
        $educationLevelList[self::EDUCATION_LEVEL_S2] = 'S2';
        $educationLevelList[self::EDUCATION_LEVEL_S3] = 'S3';
        return $educationLevelList;
    }

    public function getLevelName()
    {
        switch ($this->level) {
            case self::EDUCATION_LEVEL_SD:
                return Yii::t('app', 'Elementary');
                break;
            case self::EDUCATION_LEVEL_SMP:
                return Yii::t('app', 'Junior High');
                break;
            case self::EDUCATION_LEVEL_SMA:
                return Yii::t('app', 'Senior High');
                break;
            case self::EDUCATION_LEVEL_S1:
                return Yii::t('app', 'Degree');
                break;
            case self::EDUCATION_LEVEL_S2:
                return Yii::t('app', 'Master');
                break;
            case self::EDUCATION_LEVEL_S3:
                return Yii::t('app', 'Doctoral');
                break;
            default:
                return Yii::t('app', 'not set');
        }

    }

}
