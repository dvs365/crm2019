<?php
namespace frontend\models;
 
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
 
class ProfileUpdateForm extends Model
{
	public $id;
	public $surname;
	public $name;
	public $patronymic;
	public $position;
	public $phone;
	public $email;
	public $access;
    public $rule;
	public $status;
	public $birthday;
	public $users;
 
    /**
     * @var User
     */
    private $_user;
 
    public function __construct(\common\models\User $user, $config = [])
    {
        $this->_user = $user;
		$roles = \Yii::$app->authManager->getRolesByUser($user->id);

		$this->id = $user->id;
		$this->surname = $user->surname;
		$this->name = $user->name;
		$this->patronymic = $user->patronymic;
		$this->position = $user->position;
        $this->phone = $user->phone;
        $this->email = $user->email;
		$this->status = $user->status;
		$this->birthday = \Yii::$app->formatter->asDate($user->birthday, "php:Y-m-d");
		$this->access = !empty($roles['admin'])  ? '2' : '1';
		$permissions = Yii::$app->authManager->getPermissions();
		foreach ($permissions as $name => $permission) {
			$this->rule[$name] = \Yii::$app->authManager->checkAccess($user->id, $name)? '1':'0';
		}
        parent::__construct($config);
    }
 
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
		
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('app', 'ERROR_EMAIL_EXISTS'),
                'filter' => ['<>', 'id', $this->_user->id],
            ],
            ['email', 'string', 'max' => 255],

            ['access', 'required'],
            ['access', 'integer'],
            ['access', 'in', 'range' => [1, 2]],
            ['access', 'default', 'value' => 1],
			
            ['rule', 'safe'],
            [['rule'], 'each', 'rule' => ['integer']],

			['status', 'required'],
			['status', 'integer'],
			['status', 'in', 'range' => [0, 9, 10]],
			['status', 'default', 'value' => 9],
			
			['users', 'each', 'rule' => ['integer']],
			
			['birthday', 'date', 'format' => 'php:Y-m-d'],
        ];
    }
 
    public function update()
    {
        if ($this->validate()) {
			$auth = Yii::$app->authManager;
            $user = $this->_user;
			
			$user->surname = $this->surname;
			$user->name = $this->name;
			$user->patronymic = $this->patronymic;
			$user->position = $this->position;
			$user->phone = $this->phone;			
			$user->email = $this->email;
			$user->status = $this->status;
			$user->birthday = $this->birthday;

			$permissions = Yii::$app->authManager->getPermissions();
			foreach($permissions as $name => $permission) {
				if (!$permission->ruleName) {
					if(!empty($this->rule[$name]) && !\Yii::$app->authManager->checkAccess($user->id, $name)) {
						$auth->assign($auth->getPermission($name), $user->id);
					}elseif(isset($this->rule[$name]) && empty($this->rule[$name])){
						$auth->revoke($auth->getPermission($name), $user->id);
					}
				}
			}
			if (!empty($this->access)){
				$auth->revoke($auth->getRole('admin'), $user->id);
				$auth->revoke($auth->getRole('user'), $user->id);
				$auth->assign((($this->access == '2')? $auth->getRole('admin') : $auth->getRole('user')), $user->id);
			}
			
			if (!$user->status) {
				// Удаление всех сессий
				Yii::$app->db->createCommand()->delete('session', ['user_id' => $user->id])->execute();
			}
			
            return $user->save();
        } else {
            return false;
        }
    }
}