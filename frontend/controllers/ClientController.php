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
use yii\helpers\ArrayHelper;

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
                        $valid = $facePhone->validate() && $valid;
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
                        $valid = $faceMail->validate() && $valid;
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
                            $emptyFace = true;
                            if(array_filter($clientFace->attributes) !== []) {
                                $emptyFace = false;
                            }
                            $clientFace->client = $client->id;
                            if (! ($flag = $clientFace->save(false))) {
                                break;
                            }
                            $empty = true;
                            if (isset($facePhones[$indexFace]) && is_array($facePhones[$indexFace])){
                                foreach ($facePhones[$indexFace] as $indexPhone => $facePhone) {
                                    if(array_filter($facePhone->attributes) !== []) {
                                        $facePhone->face = $clientFace->id;
                                        if (!($flag = $facePhone->save(false))) {
                                            break 2;
                                        }
                                        $empty = false;
                                    }
                                }
                            }
                            if (isset($faceMails[$indexFace]) && is_array($faceMails[$indexFace])){
                                foreach ($faceMails[$indexFace] as $indexMail => $faceMail) {
                                    if(array_filter($faceMail->attributes) !== []) {
                                        $faceMail->face = $clientFace->id;
                                        if (!($flag = $faceMail->save(false))) {
                                            break 2;
                                        }
                                        $empty = false;
                                    }
                                }
                            }
                            if ($emptyFace && $empty) {
                                $clientFace->delete();
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
        $client = $this->findModel($id);
        $clientPhones = $client->phoneclients;
        $clientMails = $client->mailclients;
        $clientFaces = $client->faces;
        $facePhones = [];
        $oldFacePhones =[];
        $faceMails = [];
        $oldFaceMails = [];
        $clientOrganizations = $client->organizations;

        if (!empty($clientFaces)) {
            foreach ($clientFaces as $indexFace => $face) {
                $phones = $face->phonefaces;
                $mails = $face->mailfaces;
                $facePhones[$indexFace] = !empty($phones)? $phones: [new Phoneface];
                $faceMails[$indexFace] = !empty($mails)? $mails: [new Mailface];
                $oldFacePhones = ArrayHelper::merge(ArrayHelper::index($phones, 'id'), $oldFacePhones);
                $oldFaceMails = ArrayHelper::merge(ArrayHelper::index($mails, 'id'), $oldFaceMails);
            }
        }

        if ($client->load(Yii::$app->request->post()) && $client->save()) {

            // reset
            $facePhones = [];
            $faceMails = [];

            $oldClientPhoneIDs = ArrayHelper::map($clientPhones, 'id', 'id');
            $oldClientMailIDs = ArrayHelper::map($clientMails, 'id', 'id');
            $oldClientFaceIDs = ArrayHelper::map($clientFaces, 'id', 'id');
            $oldClientOrgIDs = ArrayHelper::map($clientOrganizations, 'id', 'id');

            $clientPhones = Model::createMultiple(Phoneclient::classname(), $clientPhones);
            $clientMails = Model::createMultiple(Mailclient::classname(), $clientMails);
            $clientFaces = Model::createMultiple(Face::classname(), $clientFaces);
            $clientOrganizations = Model::createMultiple(Organization::classname(), $clientOrganizations);

            Model::loadMultiple($clientPhones, Yii::$app->request->post());
            Model::loadMultiple($clientMails, Yii::$app->request->post());
            Model::loadMultiple($clientFaces, Yii::$app->request->post());
            Model::loadMultiple($clientOrganizations, Yii::$app->request->post());

            $deleteClientPhoneIDs = array_diff($oldClientPhoneIDs, array_filter(ArrayHelper::map($clientPhones, 'id', 'id')));
            $deleteClientMailIDs = array_diff($oldClientMailIDs, array_filter(ArrayHelper::map($clientMails, 'id', 'id')));
            $deleteClientFaceIDs = array_diff($oldClientFaceIDs, array_filter(ArrayHelper::map($clientFaces, 'id', 'id')));
            $deleteClientOrgIDs = array_diff($oldClientOrgIDs, array_filter(ArrayHelper::map($clientOrganizations, 'id', 'id')));

            //validate
            $valid = $client->validate();
            $valid = Model::validateMultiple($clientPhones) && $valid;
            $valid = Model::validateMultiple($clientMails) && $valid;
            $valid = Model::validateMultiple($clientFaces) && $valid;
            $valid = Model::validateMultiple($clientOrganizations) && $valid;

            $facePhonesIDs = [];
            if (isset($_POST['Phoneface'][0][0])) {
                foreach ($_POST['Phoneface'] as $indexFace => $phones) {
                    $facePhonesIDs = ArrayHelper::merge($facePhonesIDs, array_filter(ArrayHelper::getColumn($phones, 'id')));
                    foreach ($phones as $indexPhone => $phone) {
                        $data['Phoneface'] = $phone;
                        $facePhone = (isset($phone['id']) && isset($oldFacePhones[$phone['id']])) ? $oldFacePhones[$phone['id']] : new Phoneface;
                        $facePhone->load($data);
                        $facePhones[$indexFace][$indexPhone] = $facePhone;
                        $valid = $facePhone->validate() && $valid;
                    }
                }
            }
            $faceMailsIDs =[];
            if (isset($_POST['Mailface'][0][0])) {
                foreach ($_POST['Mailface'] as $indexFace => $mails) {
                    $faceMailsIDs = ArrayHelper::merge($faceMailsIDs, array_filter(ArrayHelper::getColumn($mails, 'id')));
                    foreach ($mails as $indexMail => $mail) {
                        $data['Mailface'] = $mail;
                        $faceMail = (isset($mail['id']) && isset($oldFaceMails[$mail['id']])) ? $oldFaceMails[$mail['id']] : new Mailface;
                        $faceMail->load($data);
                        $faceMails[$indexFace][$indexMail] = $faceMail;
                        $valid = $faceMail->validate() && $valid;
                    }
                }
            }

            $oldFacePhonesIDs = ArrayHelper::getColumn($oldFacePhones, 'id');
            $oldFaceMailsIDs = ArrayHelper::getColumn($oldFaceMails, 'id');

            $deleteFacePhonesIDs = array_diff($oldFacePhonesIDs, $facePhonesIDs);
            $deleteFaceMailsIDs = array_diff($oldFaceMailsIDs, $faceMailsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $dirty = empty($client->getDirtyAttributes());
                    if ($flag = $client->save(false)) {
                        if (! empty($deleteFacePhonesIDs)) {
                            Phoneface::deleteAll(['id' => $deleteFacePhonesIDs]);
                        }
                        if (! empty($deleteFaceMailsIDs)) {
                            Mailface::deleteAll(['id' => $deleteFaceMailsIDs]);
                        }

                        if (! empty($deleteClientPhoneIDs)) {
                            Phoneclient::deleteAll(['id' => $deleteClientPhoneIDs]);
                        }
                        if (! empty($deleteClientMailIDs)) {
                            Mailclient::deleteAll(['id' => $deleteClientMailIDs]);
                        }
                        if (! empty($deleteClientFaceIDs)) {
                            Face::deleteAll(['id' => $deleteClientFaceIDs]);
                        }
                        if (! empty($deleteClientOrgIDs)) {
                            Organization::deleteAll(['id' => $deleteClientOrgIDs]);
                        }

                        foreach ($clientPhones as $clientPhone) {
                            if(array_filter($clientPhone->attributes) !== []) {
                                $clientPhone->client = $client->id;
                                $dirty = $dirty && empty($clientPhone->getDirtyAttributes());
                                if (!$flag = $clientPhone->save(false)) {
                                    break;
                                }
                            }
                        }
                        foreach ($clientMails as $clientMail) {
                            if(array_filter($clientMail->attributes) !== []) {
                                $clientMail->client = $client->id;
                                $dirty = $dirty && empty($clientMail->getDirtyAttributes());
                                if (!$flag = $clientMail->save(false)) {
                                    break;
                                }
                            }
                        }
                        foreach ($clientFaces as $indexFace => $clientFace) {
                            $emptyFace = true;
                            $emptySub = true;
                            if(!empty($clientFace->fullname) || !empty($clientFace->position)) {
                                $emptyFace = false;
                            }
                            if (isset($facePhones[$indexFace]) && is_array($facePhones[$indexFace])) {
                                foreach ($facePhones[$indexFace] as $indexPhone => $phone) {
                                    if(!empty($phone->number) || !empty($phone->comment)) {
                                        $emptySub = false;
                                        break;
                                    }
                                }
                            }
                            if (isset($faceMails[$indexFace]) && is_array($faceMails[$indexFace])) {
                                foreach ($faceMails[$indexFace] as $indexMail => $mail) {
                                    if(!empty($mail->mail)) {
                                        $emptySub = false;
                                        break;
                                    }
                                }
                            }
                            if (!$emptyFace && !$emptySub) {
                                $clientFace->client = $client->id;
                                $dirty = $dirty && empty($clientFace->getDirtyAttributes());
                                if (!$flag = $clientFace->save(false)) {
                                    break;
                                }
                                foreach ($facePhones[$indexFace] as $indexPhone => $phone) {
                                    if (!empty($phone->number) || !empty($phone->comment)) {
                                        $phone->face = $clientFace->id;
                                        $dirty = $dirty && empty($phone->getDirtyAttributes());
                                        if (!($flag = $phone->save(false))) {
                                            break 2;
                                        }
                                    }
                                }
                                foreach ($facePhones[$indexFace] as $indexMail => $mail) {
                                    if (!empty($mail->mail)) {
                                        $mail->face = $clientFace->id;
                                        $dirty = $dirty && empty($mail->getDirtyAttributes());
                                        if (!($flag = $mail->save(false))) {
                                            break 2;
                                        }
                                    }
                                }
                            }
                        }
                        foreach ($clientOrganizations as $clientOrg) {
                            if (!empty($clientOrg->name)) {
                                $clientOrg->client = $client->id;
                                $dirty = $dirty && empty($clientOrg->getDirtyAttributes());
                                if (!$flag = $clientOrg->save(false)) {
                                    break;
                                }
                            }
                        }
                        if (!$dirty) {
                            $client->update = date('Y-m-d H:i:s');
                            if (! ($flag = $client->save(false))) {
                                $transaction->rollBack();
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
        }

        return $this->render('update', [
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
