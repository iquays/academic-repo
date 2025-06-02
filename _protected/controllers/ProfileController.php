<?php

namespace app\controllers;

use app\models\Profile;
use app\models\ProfileSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
                'only' => ['create', 'update', 'delete', 'view', 'index', 'picker-researcher', 'picker-writer', 'picker-servicer', 'lang'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'index', 'picker-researcher', 'picker-writer', 'picker-servicer'],
                        'allow' => true,
                        'roles' => ['member', 'admin'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['view', 'lang'],
                        'allow' => true,
                        'roles' => ['visitor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null)
    {
        if ($id == null) {
            $id = Yii::$app->user->identity->profile_id;
            return $this->render('view', [
                'profile' => $this->findModel($id),
            ]);
        }
        return $this->render('view', [
            'profile' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {

        $model = new Profile();

        if ($model->load(Yii::$app->request->post())) {
            $image = $model->uploadImage();

            if ($model->save()) {
                // Save the picture
                if ($image) { // delete old and overwrite
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                    //create thumbnail
                    $pathThumbnail = $model->getImageFileThumbnail();
                    Image::thumbnail($path, 160, 160)->save($pathThumbnail, ['quality' => 80]);
                }

                // add profile_id into related user
                $user = User::findOne(Yii::$app->user->id);
                $user->profile_id = $model->id;
                $user->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if ($id == null) {
            $model = $this->findModel(Yii::$app->user->identity->profile_id);
        } else {
            if (Yii::$app->user->can('admin')) {
                $model = $this->findModel($id);
            } else {
                throw new \yii\web\ForbiddenHttpException;
            }
        }

        $oldFile = $model->getImageFile();
        $oldFileThumbnail = $model->getImageFileThumbnail();
        $oldPicture = $model->picture;


        if ($model->load(Yii::$app->request->post())) {
            $image = $model->uploadImage();

            if ($image === false) {
                $model->picture = $oldPicture;
            }

            if ($model->save()) {
                if ($image) { // delete old and overwrite
                    if ($oldFile !== null) {
                        unlink($oldFile);
                        unlink($oldFileThumbnail);
                    }
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                    //create thumbnail
                    $pathThumbnail = $model->getImageFileThumbnail();
                    Image::thumbnail($path, 160, 160)->save($pathThumbnail, ['quality' => 80]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionPickerResearcher()
    {
        $searchModel = new ProfileSearch();
        $searchModel->is_civitas = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $modelName = 'Research';
        $modelAttribute = 'researcher';

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'modelName' => $modelName,
            'modelAttribute' => $modelAttribute
        ]);
    }

    public function actionPickerWriter()
    {
        $searchModel = new ProfileSearch();
        $searchModel->is_civitas = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $modelName = 'Publication';
        $modelAttribute = 'writer';

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'modelName' => $modelName,
            'modelAttribute' => $modelAttribute
        ]);
    }

    public function actionPickerServicer()
    {
        $searchModel = new ProfileSearch();
        $searchModel->is_civitas = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $modelName = 'CommunityService';
        $modelAttribute = 'servicer';

        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('picker', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'modelName' => $modelName,
            'modelAttribute' => $modelAttribute
        ]);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLang($value, $currentUrl)
    {
        $model = Profile::findOne([Yii::$app->user->identity->profile_id]);
        $model->language = $value;

        if ($model->save()) {
//            $currentUrl = explode('lang', Yii::$app->getRequest()->getUrl());
            return $this->redirect($currentUrl);
        } else {
            return $this->goBack();
        }

    }


}
