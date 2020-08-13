<?php
namespace frontend\models;
 
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
 
class ProfileUpdateForm extends Model
{
	public $surname;
	public $name;
	public $patronymic;
	public $position;
	public $phone;
	public $email;
    public $rule;
 
    /**
     * @var User
     */
    private $_user;
 
    public function __construct(\common\models\User $user, $config = [])
    {
        $this->_user = $user;

		$this->surname = $user->surname;
		$this->name = $user->name;
		$this->patronymic = $user->patronymic;
		$this->position = $user->position;
        $this->phone = $user->phone;
        $this->email = $user->email;
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
			
            ['rule', 'safe'],
            [['rule'], 'each', 'rule' => ['integer']],			
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

			$permissions = Yii::$app->authManager->getPermissions();
			foreach($permissions as $name => $permission) {
				if (!$permission->ruleName) {
					if(!empty($this->rule[$name]) && !\Yii::$app->authManager->checkAccess($user->id, $name)) {
						$auth->assign($auth->getPermission($name), $user->id);
					}elseif(empty($this->rule[$name])){
						$auth->revoke($auth->getPermission($name), $user->id);
					}
				}
			}

            return $user->save();
        } else {
            return false;
        }
    }
}