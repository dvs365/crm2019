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
    public $surname;
    public $name;
    public $patronymic;
    public $position;
    public $phone;
    public $email;
    public $password;
    public $access;
	public $rule;
	public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['surname', 'filter', 'filter' => 'trim'],
            ['surname', 'required'],
            ['surname', 'string', 'min' => 2, 'max' => 255],

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['patronymic', 'filter', 'filter' => 'trim'],
            ['patronymic', 'required'],
            ['patronymic', 'string', 'min' => 2, 'max' => 255],

            ['position', 'filter', 'filter' => 'trim'],
            ['position', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'match', 'pattern' => '/\+[7]{1}[0-9]{10}$/'],
            ['phone', 'required'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот e-mail уже занят.'],

            ['access', 'required'],
            ['access', 'integer'],
            ['access', 'in', 'range' => [1, 2]],
            ['access', 'default', 'value' => 1],
			
            ['rule', 'safe'],
            [['rule'], 'each', 'rule' => ['integer']],

			['status', 'integer'],
			['status', 'in', 'range' => [0, 9, 10]],
			['status', 'default', 'value' => 9],
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
        $auth = Yii::$app->authManager;
        $user = new User();
        $user->surname = $this->surname;
        $user->name = $this->name;
        $user->patronymic = $this->patronymic;
        $user->position = $this->position;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $this->password = bin2hex(openssl_random_pseudo_bytes(4));

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if($user->save() && $this->sendEmail($user)){
            $auth->assign((($this->access == '2')? $auth->getRole('admin') : $auth->getRole('user')), $user->id);
			$permissions = Yii::$app->authManager->getPermissions();
			foreach($permissions as $name => $permission) {
				!empty($this->rule[$name]) ? $auth->assign($auth->getPermission($name), $user->id) : '';
				(strpos($name, 'Own') !== false) ? $auth->assign($auth->getPermission($name), $user->id): '';
			}
            return true;
        }
        return false;

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
                ['user' => $user, 'pass' => $this->password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(' Пользователь зарегистрирован в "' . Yii::$app->name . '"')
            ->send();
    }
}
