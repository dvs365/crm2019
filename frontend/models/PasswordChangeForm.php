<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class PasswordChangeForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'validatePassword'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите пароль',
            'currentPassword' => 'Текущий пароль',
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Пароль неверный');
            }
        }
    }

    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPassword);
            return $user->save();
        } else {
            return false;
        }
    }
}