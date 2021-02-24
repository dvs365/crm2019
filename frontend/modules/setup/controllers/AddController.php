<?php

namespace frontend\modules\setup\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `setup` module
 */
class AddController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','statistic','costdelivery'],
                'rules' => [
                    [   
                        'actions' => ['index','statistic','costdelivery'],
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
        return $this->render('index');
    }
	
    public function actionStatistic()
    {
        return $this->render('statistic');
    }
	
	public function actionCostdelivery()
	{
		return $this->render('costdelivery');
	}
}