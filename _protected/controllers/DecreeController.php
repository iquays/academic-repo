<?php

namespace app\controllers;

use app\models\Decree;
use app\models\DecreeSearch;
use app\models\HasDecree;
use app\models\Lecturer;
use app\models\Student;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DecreeController implements the CRUD actions for Decree model.
 */
class DecreeController extends Controller
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
                        'roles' => ['lecturer', 'admin', 'student'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Decree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DecreeSearch();
        if (Yii::$app->user->can('lecturer')) {
            $searchModel->for_all_lecturer = 1;
            $searchModel->lecturer_id = Lecturer::findOne(['profile_id' => Yii::$app->user->identity->profile_id])->id;
        } elseif (Yii::$app->user->can('student')) {
            $searchModel->for_all_student = 1;
            $searchModel->student_id = Student::findOne(['profile_id' => Yii::$app->user->identity->profile_id])->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Decree model.
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
     * Creates a new Decree model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Decree();

        if ($model->load(Yii::$app->request->post())) {
            $file = $model->uploadFile();

            if ($model->save()) {
                // Save the file
                if ($file) {
                    $path = $model->getFile();
                    $file->saveAs($path);
                }

                // Save lecturers
                if ($model->for_all_lecturer == 0) { // only if the decree is not for all lecturer
                    if (count($model->lecturer) > 0) {
                        $i = 1;
                        foreach ($model->lecturer as $row) {
                            $hasDecree = HasDecree::find()->where(['lecturer_id' => $row, 'decree_id' => $model->id])->all(); // this line is for redundancy checking
                            if ($hasDecree == null) { // if no redundancy
                                $hasDecree = new HasDecree();
                                $hasDecree->lecturer_id = $row;
                                $hasDecree->decree_id = $model->id;
                                $hasDecree->sort = $i;
                                $hasDecree->save();
                                $i++;
                            }
                        }
                    }
                }

                // Save students
                if ($model->for_all_student == 0) { // only if the decree is not for all student
                    if (count($model->student) > 0) {
                        $i = 1;
                        foreach ($model->student as $row) {
                            $hasDecree = HasDecree::find()->where(['student_id' => $row, 'decree_id' => $model->id])->all(); // this line is for redundancy checking
                            if ($hasDecree == null) { // if no redundancy
                                $hasDecree = new HasDecree();
                                $hasDecree->student_id = $row;
                                $hasDecree->decree_id = $model->id;
                                $hasDecree->sort = $i;
                                $hasDecree->save();
                                $i++;
                            }
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
     * Updates an existing Decree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $oldFile = $model->getFile();
        $oldFileName = $model->file_name;

        if ($model->load(Yii::$app->request->post())) {
            $file = $model->uploadFile();

            if ($file === false) {
                $model->file_name = $oldFileName;
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

                // Delete all previous lecturers
                foreach ($model->hasLecturers as $hasLecturer) {
                    $hasLecturer->delete();
                }
                // Save lecturers
                if ($model->for_all_lecturer == 0) { // only if the decree is not for all lecturer
                    if (count($model->lecturer) > 0) {
                        $i = 1;
                        foreach ($model->lecturer as $row) {
                            $hasDecree = HasDecree::find()->where(['lecturer_id' => $row, 'decree_id' => $model->id])->all(); // this line is for redundancy checking
                            if ($hasDecree == null) { // if no redundancy
                                $hasDecree = new HasDecree();
                                $hasDecree->lecturer_id = $row;
                                $hasDecree->decree_id = $model->id;
                                $hasDecree->sort = $i;
                                $hasDecree->save();
                                $i++;
                            }
                        }
                    }
                }

                // Delete all previous students
                foreach ($model->hasStudents as $hasStudent) {
                    $hasStudent->delete();
                }
                // Save students
                if ($model->for_all_student == 0) { // only if the decree is not for all student
                    if (count($model->student) > 0) {
                        $i = 1;
                        foreach ($model->student as $row) {
                            $hasDecree = HasDecree::find()->where(['student_id' => $row, 'decree_id' => $model->id])->all(); // this line is for redundancy checking
                            if ($hasDecree == null) { // if no redundancy
                                $hasDecree = new HasDecree();
                                $hasDecree->student_id = $row;
                                $hasDecree->decree_id = $model->id;
                                $hasDecree->sort = $i;
                                $hasDecree->save();
                                $i++;
                            }
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Decree model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->deleteFile();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Decree model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Decree the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Decree::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
