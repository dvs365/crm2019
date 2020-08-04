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
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update'],
                'rules' => [
                    [
                        'actions' => ['index'],
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
                        'actions' => ['update'],
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
		$cookieUserID = Yii::$app->request->cookies['userID']?:false;
		$userID = !empty($model->user) ? $model->user : ($cookieUserID ? $cookieUserID->value : Yii::$app->user->identity->id);
	
		$datetime = !empty($model->date) ? strtotime($model->date) : time();
		
		$searchModel = new TodoSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere(['user' => (int)$userID]);
		
		$roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
		$clientsQuery = Client::find();
		if (!isset($roles['admin'])) {
			$clientsQuery->andWhere(['user' => Yii::$app->user->identity->id]);
		}
		$clients = $clientsQuery->andWhere(['status' => ['10','20']])->all();
		if (Yii::$app->request->isAjax) {
			return $this->renderAjax('list_cur_todo', [
				"curTodos" => (empty($status) || $status == Todo::OPEN) ? Todo::find()->where(['user' => $userID, 'status' => Todo::OPEN])->andwhere(['>','dateto', date('Y-m-d 00:00:00', $datetime)])->andwhere(['<','date', date('Y-m-d 23:59:59',$datetime)])->all():'',
				"error" => null
			]);					
		}
        return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'todoCur' => (empty($status) || $status == Todo::OPEN)?Todo::find()->where(['user' => $userID, 'status' => Todo::OPEN])->andwhere(['>','dateto', date('Y-m-d 00:00:00')])->andwhere(['<','date', date('Y-m-d 23:59:59')])->all():'',
			'todoLate' => (empty($status) || $status == Todo::LATE)?Todo::find()->where(['user' => $userID, 'status' => Todo::OPEN])->andwhere(['<','dateto', date('Y-m-d H:i:s')])->all():'',
			'user' => User::findByRole(Yii::$app->authManager->getRole('user')),
			'status' => $status,
			'clients' => $clients,
			'userID' => $userID,
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
			$userID = $model->user;
		} else {
			$cookieUserID = Yii::$app->request->cookies['userID']?:false;
			$userID = ($cookieUserID) ? $cookieUserID->value : Yii::$app->user->identity->id;
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
        ]);
	}
	
    public function actionCreate()
    {
        $model = new Todo();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = Yii::$app->request->post();

		if ($model->load($data)) {
			$model->user = \Yii::$app->user->id;
			$model->status = Todo::OPEN;
			$model->save();
			if (Yii::$app->request->isAjax) {
				return $this->renderAjax('/client/_form_list_todo', [
					"todos" => $model->find()->where(['client' => $model->client])->all(),
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
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
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
	}

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteclient($id)
    {
        return $this->findModel($id)->delete();
    }

    protected function findModel($id)
    {
        if (($model = Todo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
