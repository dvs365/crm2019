<?php


namespace frontend\rbac;

use yii\rbac\Rule;
use Yii;

class ExceptMyselfRule extends Rule
{
    public $name = 'exceptMyself'; //Имя правила

    public function execute($user_id, $item, $params)
    {
        //return isset($params['user']) ? $params['user']->id !== $user_id : false;
		return true;
    }
}