<?php

namespace app\controllers;

use app\models\Regency;
use Yii;
use yii\db\Query;
use yii\web\Controller;

/**
 * RegencyController implements the CRUD actions for Regency model.
 */
class RegencyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['searchajax'],
                'rules' => [
                    [
                        'actions' => ['searchajax'],
                        'allow' => true,
                        'roles' => ['member'],
                    ],
                ],
            ],
        ];
    }

    public function actionSearchajax($q = null, $id = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id', 'name AS text'])
                ->from('regency')
                ->where(['like', 'name', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Regency::findOne($id)->name];
        }
        return $out;

    }

}
