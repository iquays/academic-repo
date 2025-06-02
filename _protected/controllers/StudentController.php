<?php

namespace app\controllers;

use app\models\Education;
use app\models\Profile;
use app\models\Student;
use app\models\StudentSearch;
use app\models\User;
use app\models\UserState;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
                'only' => ['create', 'update', 'delete', 'view', 'index', 'picker'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['picker', 'picker2'],
                        'allow' => true,
                        'roles' => ['member', 'admin'],
                    ],
                    [
                        'actions' => ['view', 'index'],
                        'allow' => true,
                        'roles' => ['visitor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex2()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
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
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $student = new Student();
        $user = new User();

        $user->scenario = 'create';

        if ($student->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $user->setPassword($user->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $isValid = $student->validate();
            $isValid = $user->validate() && $isValid;

            if ($isValid) {
                // create blank profile and assign to user and student
                $profile = new Profile();
                $profile->name = $student->name;
                $profile->is_civitas = 1;
                $profile->save();
                $user->profile_id = $profile->id;
                $student->profile_id = $profile->id;

                if ($user->save(false)) {
                    $student->save(false);
                    // add default education
                    for ($i = 1; $i <= 6; $i++) {
                        $education = new Education();
                        $education->level = $i;
                        $education->profile_id = $profile->id;
                        $education->save();
                    }

                    // add student role
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('student');
                    $auth->assign($role, $user->id);

                    // create new user state data (for AdminLte template Sidebar
                    $userState = new UserState();
                    $userState->user_id = $user->id;
                    $userState->name = 'sidebar';
                    $userState->value = 1;
                    $userState->save();

                }
                return $this->redirect(['view', 'id' => $student->id]);
            }
//            return $this->redirect(['view', 'id' => '33']);
        }
        return $this->render('create', [
            'student' => $student,
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $student = $this->findModel($id);
        $user = $student->user;

        if ($student->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            // Set password only if password field is not empty
            if ($user->password) {
                $user->setPassword($user->password);
            }
            $isValid = $student->validate();
            $isValid = $user->validate() && $isValid;

            if ($isValid) {
                if ($user->save(false)) {
                    $student->save(false);
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('update', [
                'student' => $student,
                'user' => $user
            ]);
        }
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPicker()
    {
        // for Decree
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPicker2($callingModel)
    {
        // for Lecturing
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'callingModel' => $callingModel
        ]);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
