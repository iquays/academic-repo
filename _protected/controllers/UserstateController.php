<?php

namespace app\controllers;

use app\models\UserState;
use Yii;
use yii\web\Controller;

/**
 * UserstateController implements the CRUD actions for UserState model.
 */
class UserstateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['save'],
                'rules' => [
                    [
                        'actions' => ['save'],
                        'allow' => true,
                        'roles' => ['visitor'],
                    ],
                ],
            ],
        ];
    }

    public function actionSave($name, $value)
    {
        if (Yii::$app->user->isGuest) {
            $model = UserState::findOne(['user_id' => 99]);
            $model->name = $name;
            $model->value = $value;
            $model->save();
        } else {
            $model = UserState::findOne(['user_id' => Yii::$app->user->id, 'name' => $name]);
//            $model->name = $name;
            $model->value = $value;
            $model->save();
        }
    }


}
