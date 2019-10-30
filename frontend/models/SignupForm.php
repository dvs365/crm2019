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
    public $addUpUser;
    public $addUpAdmin;
    public $viewTodoUser;
    public $viewClientAll;
    public $upClientAll;
    public $confirmDiscount;
    public $addNoteClient;
    public $addTodoUser;
    public $addUpNewClient;

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

            [['addUpUser', 'addUpAdmin', 'viewTodoUser', 'viewClientAll', 'upClientAll', 'confirmDiscount', 'addNoteClient', 'addTodoUser', 'addUpNewClient'], 'integer'],
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

            $this->addUpUser? $auth->assign($auth->getPermission('addUpUser'), $user->id) : '';
            $this->addUpAdmin? $auth->assign($auth->getPermission('addUpAdmin'), $user->id) : '';
            $this->viewTodoUser? $auth->assign($auth->getPermission('viewTodoUser'), $user->id) : '';
            $this->viewClientAll? $auth->assign($auth->getPermission('viewClientAll'), $user->id) : '';
            $this->upClientAll? $auth->assign($auth->getPermission('upClientAll'), $user->id) : '';
            $this->confirmDiscount? $auth->assign($auth->getPermission('confirmDiscount'), $user->id) : '';
            $this->addNoteClient? $auth->assign($auth->getPermission('addNoteClient'), $user->id) : '';
            $this->addTodoUser? $auth->assign($auth->getPermission('addTodoUser'), $user->id) : '';
            $this->addUpNewClient? $auth->assign($auth->getPermission('addUpNewClient'), $user->id) : '';

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
            ->setSubject(' Пользователь зарегистрирован в &laquo' . Yii::$app->name . "&raquo")
            ->send();
    }

    public function attributeLabels(){
        return [
            'addUpUser' => 'Добавление/редактирование менеджеров',
            'addUpAdmin' => 'Добавление/редактирование расширенных пользователей',
            'viewTodoUser' => 'Просмотр дел менеджеров',
            'viewClientAll' => 'Просмотр всех клиентов',
            'upClientAll' => 'Редактирование всех клиентов',
            'confirmDiscount' => 'Согласование скидки',
            'addNoteClient' => 'Добавление заметок о клиенте',
            'addTodoUser' => 'Назначение дел менеджерам',
            'addUpNewClient' => 'Добавление/редактирование новых клиентов',
        ];
    }
}
