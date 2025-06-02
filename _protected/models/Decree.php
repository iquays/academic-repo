<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "decree".
 *
 * @property integer $id
 * @property string $title
 * @property string $number
 * @property string $date
 * @property integer $for_all_lecturer
 * @property integer $for_all_student
 * @property integer $decree_category_id
 * @property string $file_name
 *
 * @property string $fileUrl
 * @property HasDecree[] $hasDecrees
 * @property HasDecree[] $hasLecturers
 * @property HasDecree[] $hasStudents
 * @property DecreeCategory $decreeCategory
 */
class Decree extends \yii\db\ActiveRecord
{
    public $file;
    public $lecturer;
    public $student;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'decree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'number', 'date', 'decree_category_id', 'file_name'], 'required'],
            [['date'], 'safe'],
            [['decree_category_id'], 'integer'],
            [['for_all_lecturer', 'for_all_student', 'lecturer', 'student'], 'safe'],
            [['title', 'number', 'file_name'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'jpg, gif, png, pdf', 'maxSize' => 2048000, 'tooBig' => Yii::t('app', 'File size limit is 2MB')],
            [['decree_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DecreeCategory::className(), 'targetAttribute' => ['decree_category_id' => 'id']],
        ];
    }

    public function getFile()
    {
        return isset($this->file_name) ? Yii::getAlias('@uploads/decree/') . $this->file_name : null;
    }

    public function getFileUrl()
    {
        $theUrl = empty($this->file_name) ? null : Yii::$app->UrlManager->baseUrl . '/uploads/decree/' . $this->file_name;
        return $theUrl;
    }

    public function uploadFile()
    {
        $file = UploadedFile::getInstance($this, 'file');

        if (empty($file)) {
            return false;
        }
        $name = preg_replace('/\s+/', '_', $file->baseName);
        $this->file_name = $name . '_' . Yii::$app->security->generateRandomString(8) . "." . $file->extension;
//        $this->file_name = Yii::$app->security->generateRandomString(8) . "." . $file->extension;

        // the uploaded image instance
        return $file;
    }

    public function deleteFile()
    {
        $file = $this->getFile();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        return true;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'number' => Yii::t('app', 'Number'),
            'date' => Yii::t('app', 'Date'),
            'for_all_lecturer' => Yii::t('app', 'For all lecturer?'),
            'for_all_student' => Yii::t('app', 'For all student?'),
            'decree_category_id' => Yii::t('app', 'Category Name'),
            'file' => Yii::t('app', 'Document'),
            'file_name' => Yii::t('app', 'File Name'),
            'categoryName' => Yii::t('app', 'Category Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecreeCategory()
    {
        return $this->hasOne(DecreeCategory::className(), ['id' => 'decree_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasDecrees()
    {
        return $this->hasMany(HasDecree::className(), ['decree_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasLecturers()
    {
        return $this->hasMany(HasDecree::className(), ['decree_id' => 'id'])->andWhere(['student_id' => null])->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasStudents()
    {
        return $this->hasMany(HasDecree::className(), ['decree_id' => 'id'])->andWhere(['lecturer_id' => null])->orderBy('sort');
    }

    public function getCategoryName()
    {
        return $this->decreeCategory->name;
    }
}
