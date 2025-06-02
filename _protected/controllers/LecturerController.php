<?php

namespace app\controllers;

use app\models\Education;
use app\models\Lecturer;
use app\models\LecturerSearch;
use app\models\Profile;
use app\models\User;
use app\models\UserState;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LecturerController implements the CRUD actions for Lecturer model.
 */
class LecturerController extends Controller
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
                        'actions' => ['picker'],
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
     * Lists all Lecturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LecturerSearch();
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
        $searchModel = new LecturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lecturer model.
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
     * Creates a new Lecturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $lecturer = new Lecturer();
        $user = new User();

        $user->scenario = 'create';

        if ($lecturer->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $user->setPassword($user->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $isValid = $lecturer->validate();
            $isValid = $user->validate() && $isValid;

            if ($isValid) {
                // create blank profile and assign to user and student
                $profile = new Profile();
                $profile->name = $lecturer->front_title . ' ' . $lecturer->name . ' ' . $lecturer->back_title;
                $profile->is_civitas = 1;
                $profile->save();
                $user->profile_id = $profile->id;
                $lecturer->profile_id = $profile->id;

                if ($user->save(false)) {
                    $lecturer->save(false);
                    // add default education
                    for ($i = 1; $i <= 6; $i++) {
                        $education = new Education();
                        $education->level = $i;
                        $education->profile_id = $profile->id;
                        $education->save();
                    }

                    // add student role
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('lecturer');
                    $auth->assign($role, $user->id);

                    // create new user state data (for AdminLte template Sidebar
                    $userState = new UserState();
                    $userState->user_id = $user->id;
                    $userState->name = 'sidebar';
                    $userState->value = 1;
                    $userState->save();

                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'lecturer' => $lecturer,
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing Lecturer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $lecturer = $this->findModel($id);
        $user = $lecturer->user;

        if ($lecturer->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            // Set password only if password field is not empty
            if ($user->password) {
                $user->setPassword($user->password);
            }

            $isValid = $lecturer->validate();
            $isValid = $user->validate() && $isValid;

            if ($isValid) {
                if ($user->save(false)) {
                    $lecturer->save(false);
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('update', [
                'lecturer' => $lecturer,
                'user' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing Lecturer model.
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
        $searchModel = new LecturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Finds the Lecturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lecturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lecturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
