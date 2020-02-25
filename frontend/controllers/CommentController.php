<?php

namespace frontend\controllers;

use Yii;
use common\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = new Comment();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (!empty($data)) {
                if (!empty($data['count']) && !empty($data['all'])) {
                    $comments = $model->find()->where(['client' => $id])->offset((int)$data['count'])->orderBy(['id' => SORT_DESC])->all();
                }elseif (!empty($data['count'])) {
                    $comments = $model->find()->where(['client' => $id])->limit(10)->offset((int)$data['count'])->orderBy(['id' => SORT_DESC])->all();
                }
                return $this->renderAjax('/client/_form_list_comment', [
                    "comments" => $comments,
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

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($client)
    {
        $model = new Comment();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ($model->load($data)) {
                $model->user = \Yii::$app->user->id;
                $model->client = $client;
                $model->date = date('d.m.Y H:i:s');
                $model->save();
                return $this->renderAjax('/client/_form_list_comment', [
                    "comments" => $model->find()->where(['client' => $client])->limit(1)->orderBy(['id' => SORT_DESC])->all(),
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

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
