<?php

namespace frontend\controllers;

use Yii;
use common\models\Todo;
use common\models\User;
use common\models\Client;
use common\models\TodoSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TodoController implements the CRUD actions for Todo model.
 */
class TodoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
				//'only' => ['index', 'view', 'toweek', 'update', 'toclose', 'create'],
                'class' => AccessControl::className(),
                'rules' => [
					[
						'allow' => false,
						'roles' => ['?'],
					],
					[
						'actions' => ['index', 'toweek', 'create'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['view'],
						'allow' => true,
						'roles' => ['viewTodoUser'],
						'roleParams' => function() {
							return ['todo' => Todo::findOne(['id' => Yii::$app->request->get('id')])];
						}
					],
					[
						'actions' => ['update', 'toclose', 'closeclient'],
						'allow' => true,
						'roles' => ['upTodoAll'],
						'roleParams' => function() {
							return ['todo' => Todo::findOne(['id' => Yii::$app->request->get('id')])];
						}
					],
				],
            ],		
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($status = null)
    {
		
		if ($data = Yii::$app->request->post()) {
			$model = new Todo();
			$model->load($data);
			if ($model->user) {
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'userID',
					'path' => 'todo',
					'value' => $model->user,
					'expire' => '',
				]));
			}
		}		
		$cookieUserID = \Yii::$app->user->can('viewTodoUser') ? (Yii::$app->request->cookies['userID']?:false) : false;
		$userID = !empty($model->user) && \Yii::$app->user->can('viewTodoUser') ? $model->user : ($cookieUserID ? $cookieUserID->value : Yii::$app->user->identity->id);
	
		$datetime = !empty($model->date) ? strtotime($model->date) : time();
		if ($status == Todo::CLOSE) {
			$searchModel = new TodoSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere(['user' => (int)$userID]);			
		}
		
		$roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
		$clientsQuery = Client::find();
		if (!isset($roles['admin'])) {
			$clientsQuery->andWhere(['user' => Yii::$app->user->identity->id]);
		}
		$clients = $clientsQuery->andWhere(['status' => ['10','20']])->all();
		list($todoCurIDs, $todoLateIDs) = [[],[]];
		list($todoCur, $todoLate) = [[],[]];
		$todoCurIDs = Todo::find()->select('id')->where(['user' => $userID, 'status' => Todo::OPEN])
		->andwhere(['>','dateto', date('Y-m-d 00:00:00', $datetime)])
		->andwhere(['<','date', date('Y-m-d 23:59:59', $datetime)])->asArray()->column();
		if (empty($status) || $status == Todo::OPEN) {
			$todoCur = Todo::find()->where(['id' => $todoCurIDs])->orderBy(['date' => SORT_ASC])->all();
			$todoCurCnt = count($todoCurIDs);
		}
		$todoLateIDs = Todo::find()->select('id')->where(['user' => $userID, 'status' => Todo::OPEN])
		->andwhere(['<','dateto', date('Y-m-d H:i:s')])->asArray()->column();
		if (empty($status) || $status == Todo::LATE) {
			$todoLate = Todo::find()->where(['id' => $todoLateIDs])->orderBy(['date' => SORT_ASC])->all();
			$todoLateCnt = count($todoLateIDs);
		}
		$clientIDs = Todo::find()->select('client')->where(['id' => array_merge($todoCurIDs,$todoLateIDs)])->asArray()->column();
		$clientIDs = array_diff(array_unique($clientIDs),['0']);
		$clientTodoName = Client::find()->select('name')->where(['id' => $clientIDs])->indexBy('id')->asArray()->column();
		if (Yii::$app->request->isAjax) {
			return $this->renderAjax('list_cur_todo', [
				'curTodos' => $todoCur,
				'clientTodoName' => $clientTodoName,
				'datetime' => $datetime,
				'todoCurCnt' => count($todoCurIDs),
				'error' => null
			]);					
		}
		return $this->render('index', [
			'searchModel' => ($status == Todo::CLOSE) ? $searchModel : [],
            'dataProvider' => ($status == Todo::CLOSE) ? $dataProvider :[],
			'todoCur' => $todoCur,
			'todoLate' => $todoLate,
			'status' => $status,
			'clients' => $clients,
			'clientTodoName' => $clientTodoName,
			'users' => (\Yii::$app->user->can('addTodoUser'))? User::find()->all():'',
			'userID' => $userID,
			'datetime' => $datetime,
			'todoCurCnt' => count($todoCurIDs),
			'todoLateCnt' => count($todoLateIDs),
        ]);
    }

    public function actionView($id)
    {
		$userID = Yii::$app->user->identity->id;
		$roles = Yii::$app->authManager->getRolesByUser($userID);
		
		$clientsQuery = Client::find();
		if (!isset($roles['admin'])) {
			$clientsQuery->andWhere(['user' => $userID]);
		}
		$clients = $clientsQuery->andWhere(['status' => ['10','20']])->all();		
		
        return $this->render('view', [
            'todo' => $this->findModel($id),
			'clients' => $clients,
        ]);
    }

	public	function actionToweek($week = null)
	{
		if ($data = Yii::$app->request->post()) {
			$model = new Todo();
			$model->load($data);
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'userID',
                'path' => 'todo',
                'value' => $model->user,
                'expire' => '',
            ]));
			$userID = \Yii::$app->user->can('viewTodoUser') ? $model->user : Yii::$app->user->identity->id;
		} else {
			$cookieUserID = \Yii::$app->user->can('viewTodoUser') ? (Yii::$app->request->cookies['userID']?:false) : false;
			$userID = !empty($model->user) && \Yii::$app->user->can('viewTodoUser') ? $model->user : ($cookieUserID ? $cookieUserID->value : Yii::$app->user->identity->id);
		}		
				
		$datetime = \Yii::$app->request->post('date') ? Yii::$app->request->post('date') : date('d.m.Y');
		if ($week) {
			$weekWithZero = $week < 10 ? '0'.$week : $week; 
			$dayOfWeek = \DateTime::createFromFormat('d.m.Y', date('d.m.Y',strtotime(date('Y').'W'.$weekWithZero)));
		} else {
			$date = \DateTime::createFromFormat('d.m.Y', $datetime);
			$dayOfWeek = $date->format('w') != '1' ? $date->modify('last Monday') : $date;
		}
		
        for ($i = 0; $i < 7; $i++) {
            $models[$i] = Todo::find()->where(
                ['user' => $userID, 'status' => Todo::OPEN]
            )->andWhere(['or',
				['and',['<', 'date', $dayOfWeek->format('Y-m-d 23:59:59')],['>', 'dateto', $dayOfWeek->format('Y-m-d 00:00:00')]]
			]
			)->orderBy(['dateto' => SORT_ASC])->all();
            $day[$i] = \DateTime::createFromFormat('d.m.Y', $dayOfWeek->format('d.m.Y'));
            $dayOfWeek->add(new \DateInterval('P1D'));//Добавляем 1 день
        }
		
		foreach ($models as $keyDay => $todos) {
			foreach ($todos as $keyTodo => $todo) {
				$cntID[$todo->id][] = $todo->id;
				if (date('d.m.Y', strtotime($todo->date)) == date('d.m.Y', strtotime($todo->dateto))) {
					$modelsTime[date('H:i', strtotime($todo->date))][$keyDay][$todo->id] = $todo;
				} elseif (count($cntID[$todo->id]) == 1) {
					$modelsLong[$keyDay][] = $todo;
				}
			}
		}
				
		$roles = Yii::$app->authManager->getRolesByUser($userID);		
		$clientsQuery = Client::find();
		if (!isset($roles['admin'])) {
			$clientsQuery->andWhere(['user' => $userID]);
		}
		$clients = $clientsQuery->andWhere(['status' => ['10','20']])->all();
        return $this->render('toweek', [
			'clients' => $clients,
			'user' => User::findByRole(Yii::$app->authManager->getRole('user')),
			'userID' => $userID,
			'status' => Todo::OPEN,
			'week' => $week ?: \DateTime::createFromFormat('d.m.Y', date('d.m.Y'))->format('W'),
			'day' => $day,
			'modelsTime' => isset($modelsTime) ? $modelsTime : [],
			'modelsLong' => isset($modelsLong) ? $modelsLong : [],
			'cntID' => isset($cntID) ? $cntID : [],
			'users' => (\Yii::$app->user->can('addTodoUser'))? User::find()->all():'',
        ]);
	}
	
    public function actionCreate()
    {
        $model = new Todo();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = Yii::$app->request->post();

		if ($model->load($data)) {
			$model->user = ($model->user)?: \Yii::$app->user->id;
			$model->status = Todo::OPEN;
			$model->created_id = \Yii::$app->user->id;
			$model->save();
			if (Yii::$app->request->isAjax) {
				return $this->renderAjax('/client/_form_list_todo', [
					"todos" => $model->find()->where(['client' => $model->client, 'status' => Todo::OPEN])->all(),
					"error" => null
				]);					
			} else {
				return $this->redirect(['todo/index']);
			}
		} else {
			return [
				"data" => null,
				"error" => "error1"
			];
		}
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->isAjax) {
				return $this->renderAjax('/client/_form_list_todo', [
					"todos" => $model->find()->where(['client' => $model->client, 'status' => Todo::OPEN])->all(),
					"error" => null
				]);
			} else {
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
		
		/*
        return $this->render('update', [
            'model' => $model,
        ]);*/
    }

	public function actionToclose($id)
	{
		$model = $this->findModel($id);
		$model->scenario = Todo::SCENARIO_TOCLOSE;
		$model->status = Todo::CLOSE;
		$model->closed = date('Y-m-d H:i:s');
		$model->closed_id = Yii::$app->user->identity->id;
		$model->save();
		if (!Yii::$app->request->isAjax) {
			return $this->redirect(['index', 'status' => Todo::CLOSE]);
		}
		return true;
	}

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCloseclient($id)
    {
		$model = $this->findModel($id);
		$model->scenario = Todo::SCENARIO_TOCLOSE;
		$model->status = Todo::CLOSE;
		$model->closed = date('Y-m-d H:i:s');
		$model->closed_id = Yii::$app->user->identity->id;
        return $model->save();
    }

    protected function findModel($id)
    {
        if (($model = Todo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
