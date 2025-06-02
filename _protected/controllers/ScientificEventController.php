<?php

namespace app\controllers;

use app\models\ScientificEvent;
use app\models\ScientificEventSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ScientificEventController implements the CRUD actions for ScientificEvent model.
 */
class ScientificEventController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'view', 'index'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'index', 'delete'],
                        'allow' => true,
                        'roles' => ['member'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['visitor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ScientificEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScientificEventSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ScientificEvent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ScientificEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ScientificEvent();

        if ($model->load(Yii::$app->request->post())) {
            $model->profile_id = Yii::$app->user->identity->profile_id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ScientificEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnScientificEvent', ['scientificEvent' => $model])) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing ScientificEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnScientificEvent', ['scientificEvent' => $model])) {
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }


    }

    /**
     * Finds the ScientificEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScientificEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScientificEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
