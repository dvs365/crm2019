<?php


namespace frontend\rbac;

use yii\rbac\Rule;
use Yii;

class ExceptMyselfRule extends Rule
{
    public $name = 'exceptMyself'; //Имя правила

    public function execute($user_id, $item, $params)
    {
		$userModel = Yii::$app->user->identity;
		$managers = array_diff(explode(',', $userModel->managers), [$user_id]);
        return isset($params['user']) ? array_search($params['user']->id, $managers) !== false : true;
    }
}