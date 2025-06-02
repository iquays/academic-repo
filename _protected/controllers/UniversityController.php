<?php

namespace app\controllers;

use app\models\University;
use Yii;
use yii\db\Query;
use yii\web\Controller;

/**
 * RegencyController implements the CRUD actions for Regency model.
 */
class UniversityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    public function actionSearchajax($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id', 'name AS text'])
                ->from('university')
                ->where(['like', 'name', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => University::findOne($id)->name];
        }
        return $out;

    }

}
