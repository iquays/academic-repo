<?php

namespace app\controllers;

use app\models\Education;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EducationController implements the CRUD actions for Education model.
 */
class EducationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Education models.
     * @return mixed
     */
    public function actionTabularform()
    {
        if (empty(Yii::$app->user->identity->profile_id)) {
            return $this->render('error');
        } else {

            $model = new Education();
            $dataProvider = new ActiveDataProvider([
                'query' => Education::find()->where(['profile_id' => Yii::$app->user->identity->profile_id])->indexBy('id')->orderBy('level'),
            ]);
            $models = $dataProvider->getModels();

            if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                $count = 0;
                foreach ($models as $index => $m) {
                    // populate and save records for each model
                    if ($m->save()) {
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
                return $this->redirect(['tabularform']); // redirect to your next desired page
            } else {
                return $this->render('tabularform', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * Finds the Education model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Education the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Education::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
