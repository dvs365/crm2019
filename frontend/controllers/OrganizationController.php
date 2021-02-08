<?php

namespace frontend\controllers;

use Yii;
use common\models\Organization;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class OrganizationController extends Controller
{
	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
					[
						'allow' => false,
						'roles' => ['?'],
					],
					[
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['viewClientAll'],
                        'roleParams' => function() {
                            return ['client' => Organization::findOne(Yii::$app->request->get('id'))->client0];
                        }						
                    ],
					[
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['upClientAll'],
                        'roleParams' => function() {
                            return ['client' => Organization::findOne(Yii::$app->request->get('id'))->client0];
                        }						
                    ],					
				],
            ],		
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }
	
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 
				'id' => $model->id, 
				'ref' => Yii::$app->request->get('ref'), 
				'ref2c' => Yii::$app->request->get('ref2'),
			]);
		}
        return $this->render('view', [
			'firm' => $model,
		]);
    }
	
    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }	
}