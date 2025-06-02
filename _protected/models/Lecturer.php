<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lecturer".
 *
 * @property integer $id
 * @property string $nip
 * @property string $name
 * @property string $front_title
 * @property string $back_title
 * @property integer $profile_id
 * @property integer $status
 *
 * @property User $user
 * @property HasDecree[] $hasDecrees
 * @property Profile $profile
 * @property Lecturing[] $lecturings
 * @property Student[] $students
 */
class Lecturer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_ON_LEAVE = 11;
    const STATUS_PENSION = 12;
    const STATUS_EXTENDED = 13;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecturer';
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
            [['nip', 'name', 'status'], 'required'],
            [['profile_id', 'status'], 'integer'],
            [['nip'], 'string', 'min' => 18, 'tooShort' => Yii::t('app', '{attribute} should contain 18 number'), 'max' => 18],
            [['nip'], 'integer'],
            [['nip'], 'unique'],
            [['name'], 'string', 'max' => 255],
            [['front_title', 'back_title'], 'string', 'max' => 50],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nip' => Yii::t('app', 'Nip'),
            'name' => Yii::t('app', 'Name'),
            'front_title' => Yii::t('app', 'Front Title'),
            'back_title' => Yii::t('app', 'Back Title'),
            'status' => Yii::t('app', 'Status'),
            'userName' => Yii::t('app', 'Username'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['profile_id' => 'profile_id']);
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasDecrees()
    {
        return $this->hasMany(HasDecree::className(), ['lecturer_id' => 'id']);
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
    public function getLecturings()
    {
        return $this->hasMany(Lecturing::className(), ['lecturer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['guardian_lecturer_id' => 'id']);
    }

    public static function getLecturerList()
    {
        $lecturerList = [];
        foreach (Lecturer::find()->select(['id', 'front_title', 'name', 'back_title'])->asArray()->all() as $list) {
            $lecturerList[$list['id']] = $list['front_title'] . ' ' . $list['name'] . ', ' . $list['back_title'];
        }
        return $lecturerList;
    }

    public static function getStatusList()
    {
        $statusList [self::STATUS_ACTIVE] = Yii::t('app', 'Active');
        $statusList [self::STATUS_ON_LEAVE] = Yii::t('app', 'On Leave');
        $statusList [self::STATUS_PENSION] = Yii::t('app', 'Pension');
        $statusList [self::STATUS_EXTENDED] = Yii::t('app', 'Extended');
        return $statusList;
    }

}
