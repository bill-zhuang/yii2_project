<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $isNew;
    public $username;
    public $email;
    public $password;
    public $modifyPassword;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\User', 'message' => '用户名已经被占用.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\User', 'message' => '邮箱已经被占用.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'message' => '密码至少包含六个字符'],

            ['modifyPassword', 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        /*if(stristr($this->username, '@')){
            $this->email = $this->username;
        } else {
            $this->email = $this->username . '@example.com';
        }*/
        //针对用户名为汉字等情况
        $this->email = md5($this->username) . '@example.com';
        if (!$this->validate()) {
            return null;
        }

        $modelUser = new User();
        $modelUser->username = $this->username;
        $modelUser->email = $this->email;
        $modelUser->setPassword($this->password);
        $modelUser->generateAuthKey();
        $modelUser->generateEmailVerificationToken();
        $modelUser->generatePasswordResetToken();
        $modelUser->status = User::STATUS_ACTIVE;
        return $modelUser->save();
    }

    /**
     * @param $id
     * @return bool
     * @throws \yii\base\Exception
     */
    public function modifyInfo($id)
    {
        $modelUser = User::findOne($id);
        if (!empty($this->modifyPassword)) {
            $modelUser->setPassword($this->modifyPassword);
            $modelUser->generateAuthKey();
            $modelUser->generateEmailVerificationToken();
            $modelUser->generatePasswordResetToken();
        }
        $modelUser->updated_at = time();
        return $modelUser->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
