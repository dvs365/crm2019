<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use common\models\User;
use frontend\models\PasswordChangeForm;
use frontend\models\SignupForm;
use frontend\models\ProfileUpdateForm;
use yii\filters\AccessControl;
use common\models\Client;
use common\models\Todo;
/**
 * Set controller
 */
class SetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
				//'only' => ['index', 'profile','users', 'update', 'signup',],
                'class' => AccessControl::className(),
                'rules' => [
					[
						'allow' => false,
						'roles' => ['?'],
					],
					[
                        'actions' => ['signup', 'update', 'users'],
                        'allow' => true,
                        'roles' => ['addUpAdmin','addUpUser'],
						'roleParams' => function() {
							return ['user' => User::findOne(['id' => Yii::$app->request->get('id')])];
						}						
                    ],
					[
						'actions' => ['profile', 'index'],
						'allow' => true,
						'roles' => ['@'],
					],
					
				],
            ],		
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
	
    public function actionProfile()
    {
		$user = User::findOne(Yii::$app->user->identity->id);
		$model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Вы успешно изменили пароль.');
            return $this->redirect(['site/logout']);
        }

        return $this->render('profile', [
            'model' => $model,
			'user' => $user,
        ]);
    }

    public function actionUsers()
    {
		$user = User::findOne(Yii::$app->user->identity->id);
		$managerIDs = array_diff(explode(',', $user->managers), ['all', Yii::$app->user->identity->id]);
		$users = User::find()->where(['id' => $managerIDs])->all();
        return $this->render('users', [
			'users' => $users,
		]);
    }

    public function actionGoods()
    {
        return $this->render('goods');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['set/users']);
        }

        return $this->render('user/signup', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdate($id)
	{
		$user = User::findOne($id);
		$model = new ProfileUpdateForm($user);
		$cntClient = Client::find()->where(['user' => $user->id])->count();
		
		if ($model->load(Yii::$app->request->post()) && $model->update()) {
			$transaction = \Yii::$app->db->beginTransaction();
            try {
				if (!$model->status && $model->users) {
					$client = Client::find()->where(['user' => $user->id])->select('id')->asArray()->column();
					$clientParts = array_chunk($client, ceil($cntClient / count($model->users)));
					foreach ($model->users as $index => $userNew) {
						Client::updateAll(['user' => $userNew], ['id' => $clientParts[$index]]);
						Todo::updateAll(['user' => $userNew], ['and', ['client' => $clientParts[$index]], ['user' => $user->id]]);
					}
				}				
				$transaction->commit();	
			} catch (Exception $e) {
				$transaction->rollBack();
			}
			return $this->redirect(['set/users']);
		}
		return $this->render('user/update', [
			'model' => $model,
			'users' => User::find()->where(['!=', 'id', $user->id])->andWhere(['status' => User::STATUS_ACTIVE])->all(),
			'cntClient' => $cntClient,
		]);
	}
}