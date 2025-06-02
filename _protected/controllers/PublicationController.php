<?php

namespace app\controllers;

use app\models\Publicating;
use app\models\Publication;
use app\models\PublicationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PublicationController implements the CRUD actions for Publication model.
 */
class PublicationController extends Controller
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
                        'roles' => ['member'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Publication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicationSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Publication model.
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
     * Creates a new Publication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Publication();

        if ($model->load(Yii::$app->request->post())) {

            $file = $model->uploadFile();

            if ($model->save()) {
                // Save the file
                if ($file) {
                    $path = $model->getFilePaper();
                    $file->saveAs($path);
                }

                // Save the writer
                if (count($model->writer) > 0) {
                    $i = 1;
                    foreach ($model->writer as $row) {
                        $publicating = Publicating::find()->where(['profile_id' => $row, 'publication_id' => $model->id])->all(); // this query is for checking if the writer already exist
                        if ($publicating == null) { // if no redundancy
                            $publicating = new Publicating();
                            $publicating->profile_id = $row;
                            $publicating->publication_id = $model->id;
                            $publicating->sort = $i;
                            $publicating->save();
                            $i++;
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Publication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnPublication', ['publication' => $model])) {
            $oldFile = $model->getFilePaper();
            $oldFilePaper = $model->file_paper;
            if ($model->load(Yii::$app->request->post())) {
                $file = $model->uploadFile();
                if ($file === false) {
                    $model->file_paper = $oldFilePaper;
                }

                if ($model->save()) {
                    // Save the file
                    if ($file) {
                        if ($oldFile !== null) {
                            unlink($oldFile);
                        }
                        $path = $model->getFilePaper();
                        $file->saveAs($path);
                    }

                    // Delete all previous writers
                    foreach ($model->publicatings as $publicating) {
                        $publicating->delete();
                    }

                    // Save the writer
                    if (count($model->writer) > 0) {
                        $i = 1;
                        foreach ($model->writer as $row) {
                            $publicating = Publicating::find()->where(['profile_id' => $row, 'publication_id' => $model->id])->all(); // this query is for checking if the writer already exist
                            if ($publicating == null) { // if no redundancy
                                $publicating = new Publicating();
                                $publicating->profile_id = $row;
                                $publicating->publication_id = $model->id;
                                $publicating->sort = $i;
                                $publicating->save();
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
            throw new  \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Publication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnPublication', ['publication' => $model])) {
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Publication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
