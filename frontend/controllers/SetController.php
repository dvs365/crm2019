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
				'only' => ['profile','users', 'update', 'signup'],
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'update', 'users'],
                        'allow' => true,
                        'roles' => ['addUpAdmin','addUpUser'],
                    ],
                    [
                        'actions' => ['profile'],
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
		$users = User::find()->all();
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
            return $this->goHome();
        }

        return $this->render('user/signup', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdate($id)
	{
		$user = User::findOne($id);
		$model = new ProfileUpdateForm($user);
		if ($model->load(Yii::$app->request->post()) && $model->update()) {
			return $this->redirect(['index']);
		} else {
			return $this->render('user/update', [
				'model' => $model,
			]);
		}
	}
}