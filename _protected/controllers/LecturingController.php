<?php

namespace app\controllers;

use app\models\Lecturing;
use app\models\LecturingSearch;
use app\models\Studying;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LecturingController implements the CRUD actions for Lecturing model.
 */
class LecturingController extends Controller
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
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['view', 'index'],
                        'allow' => true,
                        'roles' => ['lecturer', 'admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Lecturing models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LecturingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lecturing model.
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
     * Creates a new Lecturing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lecturing();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Save students
            if (count($model->student) > 0) {
                $i = 1;
                foreach ($model->student as $row) {
                    $studying = Studying::find()->where(['student_id' => $row, 'lecturing_id' => $model->id])->all(); // this line is for redundancy checking
                    if ($studying == null) { // if no redundancy
                        $studying = new Studying();
                        $studying->student_id = $row;
                        $studying->lecturing_id = $model->id;
                        $studying->save();
                        $i++;
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lecturing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Save students
            if (count($model->student) > 0) {
                $i = 1;
                $studentList = [];
                foreach ($model->student as $row) {
                    $studentList[] = $row;
                    $studying = Studying::find()->where(['student_id' => $row, 'lecturing_id' => $model->id])->all(); // this line is for redundancy checking
                    if ($studying == null) { // if no redundancy
                        $studying = new Studying();
                        $studying->student_id = $row;
                        $studying->lecturing_id = $model->id;
                        $studying->save();
                        $i++;
                    }
                }

                //delete student not in the list
                $studyings = Studying::find()->where(['lecturing_id' => $model->id])->all();
                foreach ($studyings as $studying) {
                    if (!in_array($studying->student_id, $studentList)) {
                        $studying->delete();
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lecturing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lecturing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lecturing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lecturing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
