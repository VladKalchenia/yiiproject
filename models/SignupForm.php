<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */

/*
* @property int $id
* @property string $username
* @property string $auth_key
* @property string $password_hash
* @property string $password_reset_token
* @property string $email
* @property int $status
* @property string $created_at
* @property string $updated_at
* @property string $AccessToken
   */
class SignupForm extends Model
{
 public $username;
 public $email;
 public $password_hash;
 public $password_hash_confirm;
 public $body;
 public $verifyCode;
 protected $_user = false;


 /**
  * @return array the validation rules.
  */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['username', 'email', 'password_hash', 'password_hash_confirm'], 'required'],
            // email has to be a valid email address
            ['email', 'validateEmail'],
            ['password_hash', 'validatePassword'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password_hash);
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function signUp($email)
    {
        if ($this->validate()) {
            $this->_user = $this->getUser();
            $this->_user->setAttributes([
                'username' => $this->username,
                'auth_key' => 'randomly generated auth',
                'password_hash' => $this->password_hash($this->password_hash . Yii::$app->params['SALT'], PASSWORD_ARGON2I),
                'email' => $this->email,
                'status' => 1,
                'AccessToken' => 'randomly generated',
                'crated_at' => time(),
                'updated_at' => time(),
            ]);
            $this->_user->save();
            return true;
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
            if ($this->_user === null)
                $this->_user = new User();
        }
        return $this->_user;
    }
}
