<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;


    public function behaviors()
    {
        return [
            [
                'class' => TrimBehavior::className(),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 40],
            array(['username'], 'match', 'pattern' => '/^[\*a-zA-Z0-9]{6,14}$/','message'=>"Invalid Characters in Username ( alhanumeric Characters only)" ),
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message'=> 'New password must contain at least one lower and upper case character and a digit.'],

            ['role', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
       
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        // $user->actualpassword=$this->password;
        return $user->save() && $this->sendEmail($user,$this->password);

    }
    public function saveuser()
    {
       
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        // $user->actualpassword=$this->password;
        return $user->save();

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user,$password="")
    {
      
        Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
           'host' => Yii::$app->config->get('mail-host'),
           'username' => Yii::$app->config->get('mail-username'),
           'password' => Yii::$app->config->get('mail-password'),
           'port' => Yii::$app->config->get('mail-port'),
           'encryption' => Yii::$app->config->get('mail-encryption'),
       
        ]);

        try
        {
            return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user,'password'=>$password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Mail Service'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
        }
        catch(\Swift_TransportException $exception)
        {
            User::findOne($user->id)->delete();;

            Yii::$app->session->addFlash('register-error',"Mail Server Error :" .$exception->getMessage());

            return false;
        }
       
       
       
       
    }
}
