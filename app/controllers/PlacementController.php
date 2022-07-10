<?php

namespace app\controllers;

use Yii;
use app\models\StudentPlacement;
use app\models\search\StudentPlacement as StudentPlacementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use app\models\CommonModel;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * PlacementController implements the CRUD actions for StudentPlacement model.
 */
class PlacementController extends Controller
{
    /**
     * {@inheritdoc}
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
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all StudentPlacement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPlacementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->user->identity->role==3) {
           
            return $this->render('tc-index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tc'=>CommonModel::getTcdetailbyuserid()
            ]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 

    /**
     * Displays a single StudentPlacement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $viewFile="view";
        if (Yii::$app->user->identity->role==3) {
            $viewFile="tc-view";
        }
        return $this->render($viewFile, [
            'model' => $this->findModel($id),
            'uploadFile' => new UploadForm()
        ]);
    }

    /**
     * Creates a new StudentPlacement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentPlacement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentPlacement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentPlacement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
  if (Yii::$app ->user ->identity->role==5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentPlacement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentPlacement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPlacement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionUploadFile($id)
    {
        $code=false;
        $model = new UploadForm();
        $model->file = UploadedFile::getInstance($model, 'file');
    
        $name='uploads/appointment/Letter_'.$id.'.'.$model->file->extension;

        if ($model->validate()) {                
            $code= $model->file->saveAs( $name ,$model->file->baseName . '.' . $model->file->extension);
        }
        if ($code) {
            $model = $this->findModel($id);
            $model->file_name=$name;
            $model->save();
            Yii::$app->getSession()->addFlash(
                'successmessage','Appointment Letter Upload Successfully.'
            );
           
        }else{
            Yii::$app->getSession()->addFlash(
                'errormessage','Some Error Occurs'
            );
        }
        return $this->redirect(['view','id'=>$id]);
    }
}
