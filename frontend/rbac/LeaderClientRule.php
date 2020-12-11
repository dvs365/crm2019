<?php


namespace frontend\rbac;

use yii\rbac\Rule;
use Yii;

class LeaderClientRule extends Rule
{
    public $name = 'isLeader'; //Имя правила

    public function execute($user_id, $item, $params)
    {
		$userModel = Yii::$app->user->identity;
		$managers = array_merge(array_diff(explode(',', $userModel->managers), ['76']));
        return isset($params['client']) ? array_search($params['client']->user, $managers) !== false : false;
    }
}