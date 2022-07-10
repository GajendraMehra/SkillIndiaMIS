<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
              // ['password', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message'=> 'New password must contain at least one lower and upper case character and a digit.'],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

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
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        }
        catch(\Swift_TransportException $exception)
        {
            User::findOne($user->id)->delete();;

            Yii::$app->session->addFlash('errormessage',"Mail Server Error :" .$exception->getMessage());

            return false;
        }
        
    }
}
