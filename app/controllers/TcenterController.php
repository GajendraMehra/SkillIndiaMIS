<?php

namespace app\controllers;

use Yii;
use app\models\Tcdetail;
use app\models\TcenterBank;
use app\models\TcenterSpocoperation;
use app\models\CommonModel;
use app\models\TcenterAddress;
use app\models\search\Tcdetail as TcdetailSearch;
use yii\web\Controller;
use app\models\TpartnerDetail;
use app\models\TargetsResponse;
use app\models\search\TargetsResponse as TargetsResponseSearch;
use app\models\search\TargetJob as TargetJobSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use app\models\TargetsResponse;
use app\models\Users;
use yii\web\Response;
use app\models\search\TpartnerDetail as TpartnerDetailSearch;
use app\models\Villages;
use app\models\Cities;
use app\models\Users as User;
use app\models\TpartnerInvoice;
use app\models\TpartnerBank;
use app\models\Targets;
use app\models\TpdetailSpocoperation;
use app\models\TpdetailSpocfinance;
use app\models\TpdetailAddress;
use app\models\TpdetailCeo;
/**
 * TcenterController implements the CRUD actions for Tcdetail model.
 */
class TcenterController extends Controller
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
            ]
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
        $actionName=Yii::$app ->controller ->action->id;
        
        if ($actionName == "view"
            ||$actionName=="create"
            ||$actionName=="update"
            ||$actionName=="delete"
            ||$actionName=="index"
            ||$actionName=="check-email"
            )
        {
            $role_id = 2;
        }
        else if($actionName == "my-center"
        ||$actionName=="my-tp"
        ||$actionName=="targets"
        ||$actionName=="target-view"
        ) {
            $role_id = 3;
        }
        else
        {
            $role_id = 1;
        }
        // die;
        if (Yii::$app ->user ->identity->role != $role_id) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page.');
            
            $exception = Yii::$app ->errorHandler->exception;
            
            return $this->render('/site/error', ['exception' => $exception, 'name' => "Error", "message" => $exception]);
        }
    }

    /**
     * Lists all Tcdetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 'tp_id' => CommonModel::getTpdetailbyuserid()['id']]
       
        $searchModel = new TcdetailSearch(['tp_id' => CommonModel::getTpdetailbyuserid()['id']]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } public function actionAdminIndex()
    {
        // 'tp_id' => CommonModel::getTpdetailbyuserid()['id']]
       
        $searchModel = new TcdetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tcdetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        if (CommonModel::getTpdetailbyuserid()['id']!= $model->tp_id) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page.');
        }
        $model1 = TcenterAddress::find()->where(['tc_id' => $id])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $id])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $id])->one();
        return $this->render('view', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
            'showUpdate'=>true,
        ]);
    } 
    public function actionAdminView($id)
    {
       
        $model1 = TcenterAddress::find()->where(['tc_id' => $id])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $id])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $id])->one();
        return $this->render('admin-view', [
            'model' => $this->findModel($id),
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
            'showUpdate'=>true,
        ]);
    } 

    public function actionTargetView($id)
    {  
        $tcdetails=CommonModel::getTcdetailbyuserid();
        

        $target=TargetsResponse::findOne($id);
        if ($target->tc_id!= $tcdetails['id']) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page.');
        }
        return $this->render('targetview', [
            'model' => $target,
        ]);
    }
    public function actionMyCenter()
    {

        $tcdetails=CommonModel::getTcdetailbyuserid();
        Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
        
        // Yii::$app->session->addFlash('successcreated', "Created Successfully");
       
        $model1 = TcenterAddress::find()->where(['tc_id' => $tcdetails['id']])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $tcdetails['id']])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $tcdetails['id']])->one();
        return $this->render('view', [
            'model' => $this->findModel($tcdetails['id']),
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
            'showUpdate'=>false,
        ]);
    }
    public function actionMyTp()
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
        $id= $tcdetails['tp_id'];
        $modelTpartnerBank = new TpartnerBank();
        $modelTpartnerInvoice = new TpartnerInvoice();
        $modelTpdetailAddress = new TpdetailAddress();
        $modelTpdetailSpocoperation = new TpdetailSpocoperation();
        $modelTpdetailSpocfinance = new TpdetailSpocfinance();
        $modelTpdetailCeo = new TpdetailCeo();

        return $this->render('my-tp', [
            'model' => TpartnerDetail::findOne($id),
             'modelTpartnerBank' => $modelTpartnerBank->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpartnerInvoice' => $modelTpartnerInvoice->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailAddress' => $modelTpdetailAddress->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocoperation' => $modelTpdetailSpocoperation->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocfinance' => $modelTpdetailSpocfinance->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailCeo' => $modelTpdetailCeo->find() ->andWhere(['tp_id' => $id])->one() ,
        
        ]);
    }
 public function actionTargets()
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
  

        $searchModel = new TargetsResponseSearch(['tc_id'=>$tcdetails['id'],'status'=>1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('targets', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>"TARGETS Assigned by T.P"
        ]);
    }

    public function actionCheckEmail()
    {

        $post=Yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Users::find()->where(['email' => $post['email']])->one()) {
        return true;
        }
        return false;
    }
    
    /**
     * Creates a new Tcdetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tcdetail();
        $model1 = new TcenterAddress();
        $model2 = new TcenterBank();
        $model3 = new TcenterSpocoperation();
        $model->status=1;
        $model->tp_id=CommonModel::getTpdetailbyuserid()['id'];
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');  
        $model1->updated_at = date('Y-m-d H:i:s');
        $model1->edited_by = Yii::$app->user->id;
        $model1->created_at = date('Y-m-d H:i:s');  
        $model2->updated_at = date('Y-m-d H:i:s');
        $model2->edited_by = Yii::$app->user->id;
        $model2->created_at = date('Y-m-d H:i:s'); 
        $model3->updated_at = date('Y-m-d H:i:s');
        $model3->edited_by = Yii::$app->user->id;
        $model3->created_at = date('Y-m-d H:i:s');
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model1->load(Yii::$app->request->post()) ;
            $model2->load(Yii::$app->request->post()) ;
            $model3->load(Yii::$app->request->post()) ;
      
            $model->validate();
           
            $model1->validate();
            $model2->validate();
            $model3->validate();
            if (
            (sizeof($model->errors)==0)
            && (sizeof($model1->errors)==1)
            && (sizeof($model2->errors)==1)
            && (sizeof($model3->errors)==1)
            ) {
                $model->save();
                $model1->tc_id=$model->id;
                $model2->tc_id=$model->id;
                $model3->tc_id=$model->id;
                $model1->save();
                $model2->save();
                $model3->save();
            //   die;
                 return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
        ]);
       
    }

    /**
     * Updates an existing Tcdetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (CommonModel::getTpdetailbyuserid()['id']!= $model->tp_id) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page.');
        }
        $model1 = TcenterAddress::find()->where(['tc_id' => $id])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $id])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $id])->one();
        if ($model->load(Yii::$app->request->post()) 
        &&$model1->load(Yii::$app->request->post()) 
            && $model2->load(Yii::$app->request->post()) 
            && $model3->load(Yii::$app->request->post()) 
        && $model->save()
        && $model1->save()
        && $model2->save()
        && $model3->save()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
        ]);
    }

    /**
     * Deletes an existing Tcdetail model.
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

        $count=TargetsResponse::find()->where(['tc_id'=>$id])->count();
        if ($count!=0) {
            throw new \yii\web\HttpException(403, 'Can not Delete this center anymore. This center has active Targets. ');
        }
        
       
        if($this->findModel($id)->delete())
        Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tcdetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tcdetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tcdetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
