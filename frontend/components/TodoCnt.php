<?php

namespace frontend\components;

use Yii;
use common\models\Todo;
use yii\base\Component;

class TodoCnt extends Component {

    public function cur() {
		//$cookieUserID = \Yii::$app->user->can('viewTodoUser') ? (Yii::$app->request->cookies['userID']?:false) : false;
		//$userID = $cookieUserID ? $cookieUserID->value : Yii::$app->user->identity->id;
		$userID = Yii::$app->user->identity->id;
        $todosCur = Todo::find()->where(['user' => $userID, 'status' => Todo::OPEN])
		->andWhere(['>','dateto', date('Y-m-d 00:00:00')])
		->andWhere(['<','date', date('Y-m-d 23:59:59')])
		->count();
        return $todosCur;
    }
	
    public function last() {
		//$cookieUserID = \Yii::$app->user->can('viewTodoUser') ? (Yii::$app->request->cookies['userID']?:false) : false;
		//$userID = $cookieUserID ? $cookieUserID->value : Yii::$app->user->identity->id;
		$userID = Yii::$app->user->identity->id;		
        $todosLast = Todo::find()->where(['user' => $userID, 'status' => Todo::OPEN])
		->andWhere(['<','dateto', date('Y-m-d H:i:s')])
		->count();
        return $todosLast;
    }
	
}