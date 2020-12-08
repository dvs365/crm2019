<?php


namespace frontend\rbac;

use yii\rbac\Rule;


class LeaderClientRule extends Rule
{
    public $name = 'isLeader'; //Имя правила

    public function execute($user_id, $item, $params)
    {
		return true;
        //return isset($params['user'])? array_search($params['user']->id, explode(',', $users)) !== false : false;
    }
}