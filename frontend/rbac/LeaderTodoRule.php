<?php


namespace frontend\rbac;

use yii\rbac\Rule;
use Yii;

class LeaderTodoRule extends Rule
{
    public $name = 'isLeaderTodo'; //Имя правила

    public function execute($user_id, $item, $params)
    {
		$userModel = Yii::$app->user->identity;
		$managers = array_merge(explode(',', $userModel->managers), [$user_id]);
        return isset($params['todo']) ? array_search($params['todo']->user, $managers) !== false : false;
    }
}