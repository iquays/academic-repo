<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $repeatNewPassword;

    /**
     * @var \app\models\User
     */

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'newPassword', 'repeatNewPassword'], 'required'],
            [['password'], 'validatePassword'],
            [['newPassword', 'repeatNewPassword'], 'safe'],
            [['repeatNewPassword'], 'comparePassword']
        ];
    }

    /**
     * Compare new password
     */
    public function comparePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!($this->newPassword == $this->repeatNewPassword)) {
                $this->addError($attribute, Yii::t('app', 'Your new password does not match'));
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute The attribute currently being validated.
     * @param array $params The additional name-value pairs.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = \app\models\User::findOne(Yii::$app->user->id);

            if (!$user || !$user->validatePassword($this->password)) {

                $this->addError($attribute, Yii::t('app', 'Your password is wrong'));
            }
        }
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Current password'),
            'newPassword' => Yii::t('app', 'New password'),
            'repeatNewPassword' => Yii::t('app', 'Repeat your new password'),
        ];
    }

    /**
     * Change the password if everything correct
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = \app\models\User::findOne(Yii::$app->user->id);
            $user->setPassword($this->newPassword);
            $user->save(false);
            return true;
        } else {
            return false;
        }
    }

}
