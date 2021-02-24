<?php

namespace frontend\modules\setup\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use frontend\models\ProfileUpdateForm;
use common\models\Client;
/**
 * Default controller for the `setup` module
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','signup','update'],
                'rules' => [
                    [   
                        'actions' => ['index','signup','update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
			'users' => User::findAll(\Yii::$app->user->identity->managerIDs),
		]);
    }
	
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['/setup/user']);
        }

        return $this->render('/user/signup', [
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
			return $this->redirect(['/setup/user']);
		}
		return $this->render('/user/update', [
			'model' => $model,
			'users' => User::find()->where(['!=', 'id', $user->id])->andWhere(['status' => User::STATUS_ACTIVE])->all(),
			'cntClient' => $cntClient,
		]);
	}	
}