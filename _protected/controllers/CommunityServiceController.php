<?php

namespace app\controllers;

use app\models\CommunityService;
use app\models\CommunityServiceSearch;
use app\models\CommunityServicing;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CommunityServiceController implements the CRUD actions for CommunityService model.
 */
class CommunityServiceController extends Controller
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
     * Lists all CommunityService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommunityServiceSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CommunityService model.
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
     * Creates a new CommunityService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommunityService();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($model->save()) {
                // Save the Servicer
                if (count($model->servicer) > 0) {
                    $i = 1;
                    foreach ($model->servicer as $row) {
//                        $communityServicing = CommunityServicing::find()->where(['profile_id' => $row, 'community_service_id' => $model->id])->all(); // this query is for checking redundancy
//                        if ($communityServicing == null) { // if no redundancy
                        $communityServicing = new CommunityServicing();
                        $communityServicing->profile_id = $row;
                        $communityServicing->community_service_id = $model->id;
                        $communityServicing->sort = $i;
                        $communityServicing->save();
                        $i++;
//                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CommunityService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnCommunityService', ['communityService' => $model])) {
            if ($model->load(Yii::$app->request->post())) {

                if ($model->save()) {
                    // Delete all previous servicer
                    foreach ($model->communityServicings as $cS) {
                        $cS->delete();
                    }

                    // Save the servicer
                    if (count($model->servicer) > 0) {
                        $i = 1;
                        foreach ($model->servicer as $row) {
                            $communityServicing = CommunityServicing::find()->where(['profile_id' => $row, 'community_service_id' => $model->id])->all(); // this query is for checking redundancy
                            if ($communityServicing == null) { // if no redundancy
                                $communityServicing = new CommunityServicing();
                                $communityServicing->profile_id = $row;
                                $communityServicing->community_service_id = $model->id;
                                $communityServicing->sort = $i;
                                $communityServicing->save();
                                $i++;
                            }
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing CommunityService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnCommunityService', ['communityService' => $model])) {
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }

    }

    /**
     * Finds the CommunityService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CommunityService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommunityService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
