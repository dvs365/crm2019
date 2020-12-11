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
		$managers = array_merge(explode(',', $userModel->managers), [$user_id]);
        return isset($params['client']) ? array_search($params['client']->user, $managers) !== false : false;
    }
}