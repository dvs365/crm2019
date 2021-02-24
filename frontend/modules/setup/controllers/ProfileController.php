<?php

namespace frontend\modules\setup\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use Yii;
use frontend\models\PasswordChangeForm;

/**
 * Default controller for the `setup` module
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
					[
						'allow' => false,
						'roles' => ['?'],
					],				
                    [   
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$user = User::findOne(Yii::$app->user->identity->id);
		$model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Вы успешно изменили пароль.');
            return $this->redirect(['site/logout']);
        }

        return $this->render('index', [
            'model' => $model,
			'user' => $user,
        ]);
    }
}