<?php

namespace app\controllers;

use app\models\ProfessionalMembership;
use app\models\ProfessionalMembershipSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProfessionalMembershipController implements the CRUD actions for ProfessionalMembership model.
 */
class ProfessionalMembershipController extends Controller
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
                'class' => \yii\filters\AccessControl::className(),
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
     * Lists all ProfessionalMembership models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfessionalMembershipSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfessionalMembership model.
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
     * Creates a new ProfessionalMembership model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfessionalMembership();

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
     * Updates an existing ProfessionalMembership model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateOwnProfessionalMembership', ['professionalMembership' => $model])) {
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
     * Deletes an existing ProfessionalMembership model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateOwnProfessionalMembership', ['professionalMembership' => $model])) {
            $model->delete();
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the ProfessionalMembership model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProfessionalMembership the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProfessionalMembership::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
