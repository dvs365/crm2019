<?php
namespace frontend\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $passwordr;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*_-])(?=.*[a-zа-яё])(?=.*[A-ZА-ЯЁ])[0-9a-zа-яёA-ZА-ЯЁ!@#$%^&*_-]{8,}/'],

            ['passwordr', 'required'],
            ['passwordr', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],

        ];
    }

    public function attributeLabels(){
        return [
            'password' => 'Новый пароль',
            'passwordr' => 'Повторите пароль',
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
