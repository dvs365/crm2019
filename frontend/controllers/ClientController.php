<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Client;
use common\models\Phoneclient;
use common\models\Mailclient;
use common\models\Face;
use common\models\Phoneface;
use common\models\Mailface;
use common\models\Organization;
use common\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\base\Model;

class ClientController extends Controller
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
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $client = new Client();
        $clientPhones = [new Phoneclient];
        $clientMails = [new Mailclient];
        $clientFaces = [new Face];
        $facePhones = [[new Phoneface]];
        $faceMails = [[new Mailface]];
        $clientOrganizations = [new Organization];

        if ($client->load(Yii::$app->request->post())) {

            $clientPhones = Model::createMultiple(Phoneclient::classname());
            $clientMails = Model::createMultiple(Mailclient::classname());
            $clientFaces = Model::createMultiple(Face::classname());
            $clientOrganizations = Model::createMultiple(Organization::classname());

            Model::loadMultiple($clientPhones, Yii::$app->request->post());
            Model::loadMultiple($clientMails, Yii::$app->request->post());
            Model::loadMultiple($clientFaces, Yii::$app->request->post());
            Model::loadMultiple($clientOrganizations, Yii::$app->request->post());

            //validate all models
            $valid = $client->validate();

            $valid = Model::validateMultiple($clientPhones) && $valid;
            $valid = Model::validateMultiple($clientMails) && $valid;
            $valid = Model::validateMultiple($clientFaces ) && $valid;
            $valid = Model::validateMultiple($clientOrganizations) && $valid;

            if(isset($_POST['Phoneface'][0][0])){
                foreach ($_POST['Phoneface'] as $indexFace => $phones){
                    foreach ($phones as $indexPhone => $phone){
                        $data['Phoneface'] = $phone;
                        $facePhone = new Phoneface;
                        $facePhone ->load($data);
                        $facePhones[$indexFace][$indexPhone] = $facePhone;
                        $valid = $facePhone->validate();
                    }
                }
            }

            if(isset($_POST['Mailface'][0][0])){
                foreach ($_POST['Mailface'] as $indexFace => $mails){
                    foreach ($mails as $indexMail => $mail){
                        $data['Mailface'] = $mail;
                        $faceMail = new Mailface;
                        $faceMail ->load($data);
                        $faceMails[$indexFace][$indexMail] = $faceMail;
                        $valid = $faceMail->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $client->save(false)) {
                        foreach ($clientPhones as $clientPhone) {
                            if(array_filter($clientPhone->attributes) !== []){
                                $clientPhone->client = $client->id;
                                if (!($flag = $clientPhone->save(false))){
                                    break;
                                }
                            }
                        }
                        foreach ($clientMails as $clientMail) {
                            if(array_filter($clientMail->attributes) !== []) {
                                $clientMail->client = $client->id;
                                if (!($flag = $clientMail->save(false))) {
                                    break;
                                }
                            }
                        }
                        foreach ($clientFaces as $indexFace => $clientFace) {
                            $clientFace->client = $client->id;
                            if (! ($flag = $clientFace->save(false))) {
                                break;
                            }
                            if (isset($facePhones[$indexFace]) && is_array($facePhones[$indexFace])){
                                foreach ($facePhones[$indexFace] as $indexPhone => $facePhone) {
                                    if(array_filter($facePhone->attributes) !== []) {
                                        $facePhone->face = $clientFace->id;
                                        if (!($flag = $facePhone->save(false))) {
                                            break;
                                        }
                                    }
                                }
                            }
                            if (isset($faceMails[$indexFace]) && is_array($faceMails[$indexFace])){
                                foreach ($faceMails[$indexFace] as $indexMail => $faceMail) {
                                    if(array_filter($faceMail->attributes) !== []) {
                                        $faceMail->face = $clientFace->id;
                                        if (!($flag = $faceMail->save(false))) {
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        foreach ($clientOrganizations as $clientOrg) {
                            if(array_filter($clientOrg->attributes) !== []) {
                                $clientOrg->client = $client->id;
                                if (!($flag = $clientOrg->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $client->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }


            return $this->redirect(['view', 'id' => $client->id]);
        }

        return $this->render('create', [
            'model' => $client,
            'modelsClientPhone' => (empty($clientPhones)) ? [new Phoneclient] : $clientPhones,
            'modelsClientMail'  => (empty($clientMails)) ? [new Mailclient] : $clientMails,
            'modelsClientFace'  => (empty($clientFaces)) ? [new Face] : $clientFaces,
            'modelsFacePhone'  => (empty($facePhones)) ? [[new Phoneface]] : $facePhones,
            'modelsFaceMail'  => (empty($faceMails)) ? [[new Mailface]] : $faceMails,
            'modelsOrganization' => (empty($clientOrganizations)) ? [new Organization] : $clientOrganizations,
            'modelsUser' => User::find()->all(),
        ]);
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

    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
