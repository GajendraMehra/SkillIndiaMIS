<?php

namespace app\controllers;

use Yii;
use app\models\Sector;
use app\models\search\Sector as SectorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SectorController implements the CRUD actions for Sector model.
 */
class SectorController extends Controller
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

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            # code...
            $this->displayError();
        }
        return parent::beforeAction($action);
    }
    
    public function displayError()
    {
        // echo "error";
        if (Yii::$app->user->identity->role!=1&&Yii::$app->user->identity->role!=5) {
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page. Contact admin');
        
        $exception = Yii::$app->errorHandler->exception;
       
        return $this->render('/site/error', ['exception' => $exception
          ,'name'=>"Error",
          "message"=> $exception ]);
        }
    }
    /**
     * Lists all Sector models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SectorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sector model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sector model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

       
        $model = new Sector();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successcreated', "Created Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sector model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

            
            $model=   $this->findModel($id) ;
   if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successupdated', "Updated Successfully");



            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sector model.
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
        throw new \yii\web\HttpException(403,
        'Can not Delete . Critical Data');
        // if($this->findModel($id)->delete())
        // Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sector model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sector the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sector::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionMultipleDelete()
    {
        $pk = Yii::$app->request->post('row_id');

        foreach ($pk as $key => $id) 
        {
            if($this->findModel($id)->delete())
            Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        }

        return $this->redirect(['index']);

    }
}
