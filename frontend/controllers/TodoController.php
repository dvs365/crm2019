<?php

namespace frontend\controllers;

use Yii;
use common\models\Todo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TodoController implements the CRUD actions for Todo model.
 */
class TodoController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Todo::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($client)
    {
        $model = new Todo();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ($model->load($data)) {
                $model->user = \Yii::$app->user->id;
                $model->client = $client;
                $model->status = Todo::OPEN;
                $model->save();
                return $this->renderAjax('/client/_form_list_todo', [
                    "todos" => $model->find()->where(['client' => $client])->all(),
                    "error" => null
                ]);
            } else {
                return [
                    "data" => null,
                    "error" => "error1"
                ];
            }
        } else {
            return [
                "data" => null,
                "error" => "error2"
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
