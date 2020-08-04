<?php


namespace frontend\rbac;

use yii\rbac\Rule;


class AuthorTodoRule extends Rule
{
    public $name = 'isAuthorTodo'; //Èìÿ ïğàâèëà

    public function execute($user_id, $item, $params)
    {
        return isset($params['todo'])? $params['todo']->user == $user_id : false;
    }
}