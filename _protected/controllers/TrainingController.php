<?php

namespace app\controllers;

use app\models\Training;
use app\models\TrainingSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TrainingController implements the CRUD actions for Training model.
 */
class TrainingController extends Controller
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
     * Lists all Training models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Training model.
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
     * Creates a new Training model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Training();

        if ($model->load(Yii::$app->request->post())) {
            $model->profile_id = Yii::$app->user->identity->profile_id;

            $file = $model->uploadFile();

            if ($model->save()) {
                // Save the file
                if ($file) {
                    $path = $model->getFile();
                    $file->saveAs($path);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Training model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateOwnTraining', ['training' => $model])) {
            $oldFile = $model->getFile();
            $oldCertificate = $model->certificate;

            if ($model->load(Yii::$app->request->post())) {
                $file = $model->uploadFile();

                if ($file === false) {
                    $model->certificate = $oldCertificate;
                }

                if ($model->save()) {
                    // delete old and overwrite
                    if ($file) {
                        if ($oldFile !== null) {
                            unlink($oldFile);
                        }
                        $path = $model->getFile();
                        $file->saveAs($path);
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
     * Deletes an existing Training model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // delete only if current user is the owner
        if (Yii::$app->user->can('updateOwnTraining', ['training' => $model])) {
            $model->deleteFile();
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }


    }

    /**
     * Finds the Training model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Training the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Training::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
