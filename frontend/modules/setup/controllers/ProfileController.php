<?php

namespace frontend\modules\setup\controllers;

use yii\web\Controller;
use common\models\User;
use Yii;
use frontend\models\PasswordChangeForm;

/**
 * Default controller for the `setup` module
 */
class ProfileController extends Controller
{
    /**
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