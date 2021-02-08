<?php


namespace frontend\rbac;

use yii\rbac\Rule;


class AuthorRule extends Rule
{
    public $name = 'isAuthor'; //Имя правила

    public function execute($user_id, $item, $params)
    {
        return isset($params['client'])? $params['client']->user == $user_id || $params['client']->status == $params['client']::REJECT : false;
    }
}