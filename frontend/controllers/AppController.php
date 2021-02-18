<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * App controller
 */
class AppController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['statistic'],
                'rules' => [
                    [   
                        'actions' => ['statistic'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionStatistic()
    {
		$m = (isset($_GET['m']))?($_GET['m']):'0';
        return $this->render('statistic');
    }
}
