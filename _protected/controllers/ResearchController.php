<?php

namespace app\controllers;

use app\models\Research;
use app\models\Researching;
use app\models\ResearchSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ResearchController implements the CRUD actions for Research model.
 */
class ResearchController extends Controller
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
     * Lists all Research models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResearchSearch();
        $searchModel->profile_id = Yii::$app->user->identity->profile_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Research model.
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
     * Creates a new Research model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Research();

        if ($model->load(Yii::$app->request->post())) {

            $fileP = $model->uploadFileProposal();
            $fileR = $model->uploadFileReport();

            if ($model->save()) {
                // Save the file
                if ($fileP) {
                    $path = $model->getFileProposal();
                    $fileP->saveAs($path);
                }
                if ($fileR) {
                    $path = $model->getFileReport();
                    $fileR->saveAs($path);
                }

                // Save researchers
                if (count($model->researcher) > 0) {
                    $i = 1;
                    foreach ($model->researcher as $row) {
                        $researching = Researching::find()->where(['profile_id' => $row, 'research_id' => $model->id])->all(); // this query is for checking redundancy
                        if ($researching == null) { // if no redundancy
                            $researching = new Researching();
                            $researching->profile_id = $row;
                            $researching->research_id = $model->id;
                            $researching->sort = $i;
                            $researching->save();
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
     * Updates an existing Research model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnResearch', ['research' => $model])) {
            $oldFileP = $model->getFileProposal();
            $oldFileProposal = $model->file_proposal;

            $oldFileR = $model->getFileProposal();
            $oldFileReport = $model->file_report;

            if ($model->load(Yii::$app->request->post())) {
                $fileP = $model->uploadFileProposal();
                $fileR = $model->uploadFileReport();

                if ($fileP === false) {
                    $model->file_proposal = $oldFileProposal;
                }

                if ($fileR === false) {
                    $model->file_report = $oldFileReport;
                }

                if ($model->save()) {
                    if ($fileP) {
                        if ($oldFileP !== null) {
                            unlink($oldFileP);
                        }
                        $path = $model->getFileProposal();
                        $fileP->saveAs($path);
                    }
                    if ($fileR) {
                        if ($oldFileR !== null) {
                            unlink($oldFileR);
                        }
                        $path = $model->getFileReport();
                        $fileR->saveAs($path);
                    }

                    // Delete all previous researchers
                    foreach ($model->researchings as $r) {
                        $r->delete();
                    }

                    // Save researcher(s)
                    if (count($model->researcher) > 0) {
                        $i = 1;
                        foreach ($model->researcher as $row) {
                            $researching = Researching::find()->where(['profile_id' => $row, 'research_id' => $model->id])->all(); // this query is for checking redundancy
                            if ($researching == null) { // if no redundancy
                                $researching = new Researching();
                                $researching->profile_id = $row;
                                $researching->research_id = $model->id;
                                $researching->sort = $i;
                                $researching->save();
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
     * Deletes an existing Research model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateOwnResearch', ['research' => $model])) {
            $model->deleteFileProposal();
            $model->deleteFileReport();
            $model->delete();

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Research model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Research the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Research::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
