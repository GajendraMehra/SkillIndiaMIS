<?php
    namespace app\models;
   
    use Yii;
    use yii\base\Model;
    use app\models\Login;
   
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
       
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                [['newpass','repeatnewpass'], 'string','min'=>6, 'max' => 20],
                ['newpass', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message'=> 'Password must contain at least one lower and upper case character and a digit.'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
        public function behaviors()
        {
            return [
                [
                    'class' => TrimBehavior::className(),
                ],
            ];
        }
       
        public function findPasswords($attribute, $params){

            $user = Users::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
      

            if (!Yii::$app->security->validatePassword($this->oldpass, $user->password_hash)) {
                Yii::$app->session->addFlash('errormessage','Old password is incorrect');
                 $this->addError($attribute,'Old password is incorrect');

                // $this->addError($attribute,);
            }
            // ;            $password = $user->password;
            // if($password!=$this->oldpass)
        }
       
        public function attributeLabels(){
            return [
                'oldpass'=>'Old Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Repeat New Password',
            ];
        }
    } 