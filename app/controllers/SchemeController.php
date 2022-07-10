<?php

namespace app\controllers;

use Yii;
use app\models\Scheme;
use app\models\SchemeJobs;
use app\models\Targets;
use app\models\search\Scheme as SchemeSearch;
use app\models\search\SchemeJobs as SchemeJobsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SchemeController implements the CRUD actions for Scheme model.
 */
class SchemeController extends Controller
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
     * Lists all Scheme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTest()
    {
        // $searchModel = new SchemeSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('test', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Scheme model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new SchemeJobsSearch(['scheme_id'=>$id]);
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            // 'model1' => $dataProvider
        ]);
    }

    /**
     * Creates a new Scheme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scheme();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
              
        // die;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successcreated', "Created Successfully");

            
             
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
                   ]);
    }

    /**
     * Updates an existing Scheme model.
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
     * Deletes an existing Scheme model.
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
     * Finds the Scheme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scheme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scheme::findOne($id)) !== null) {
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
