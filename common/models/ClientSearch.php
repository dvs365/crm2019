<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form of `common\models\Client`.
 */
class ClientSearch extends Client
{

    public $permonth;
    public $task;
    public $search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'status', 'discount', 'disconfirm', 'update_u', 'update_a', 'permonth'], 'integer'],
            [['name', 'address', 'discomment', 'update', 'search', 'task'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Client::find();
/*
        if (Yii::$app->user->can('user')) {
            $query->andFilterWhere([
                'user' => Yii::$app->user->id,
            ]);
        }
*/
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $searchArr = explode('|', $this->search);
        list($mails, $phones) = [[],[]];
        foreach ($searchArr as $searchKey => $searchIt) {
            $searchPhone = preg_replace("/[^0-9]/","",$searchIt);
            if (strpos($searchIt, '@') && mb_strlen($searchIt) > 3) {
                $mails[] = trim($searchIt);
                unset($searchArr[$searchKey]);
            }elseif (mb_strlen($searchPhone) > 5) {
                if (mb_strlen($searchPhone) == 11 && ($searchPhone[0] == 7 || $searchPhone[0] == 8)){
                    $searchPhone = substr($searchPhone, 1);
                }
                $phones[] = strrev($searchPhone);
                unset($searchArr[$searchKey]);
            }elseif (mb_strlen($searchIt) < 4) {
                unset($searchArr[$searchKey]);
            }
        }
        if ($phones || $mails) {
            list($idsPhone, $idsMail) = [[],[]];
            if ($phones) {
                $qPhoneClient = Phoneclient::find();
                $qPhoneFace = Phoneface::find();
                foreach ($phones as $phone) {
                    $qPhoneClient->orWhere(['LIKE', 'number_mirror', $phone.'%', false]);
                    $qPhoneFace->orWhere(['LIKE', 'number_mirror', $phone.'%', false]);
                }
                $ids1 = $qPhoneClient->select('client')->asArray()->column();
                $ids11 = [];
                if ($face1 = $qPhoneFace->select('face')->asArray()->column()) {
                    $ids11 = Face::find()->andWhere(['in','id', $face1])->select('client')->asArray()->column();
                }
                $idsPhone = array_merge($ids1, $ids11);
            }
            if ($mails) {
                $qMailClient = Mailclient::find();
                $qMailFace = Mailface::find();
                foreach ($mails as $mail) {
                    $qMailClient->orWhere(['LIKE', 'mail', $mail.'%', false]);
                    $qMailFace->orWhere(['LIKE', 'mail', $mail.'%', false]);
                }
                $ids2 = $qMailClient->select('client')->asArray()->column();
                $ids22 = [];
                if ($face2 = $qMailFace->select('face')->asArray()->column()) {
                    $ids22 = Face::find()->andWhere(['in','id', $face2])->select('client')->asArray()->column();
                }
                $idsMail = array_merge($ids2, $ids22);
            }
            $ids = array_unique(array_merge($idsPhone,$idsMail));
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user' => \Yii::$app->user->can('user')? \Yii::$app->user->id : $this->user,
        ]);
        if ($this->permonth) {
            $delay = (int)$this->permonth * 30;
            $query->andWhere([
                '>', 'show_u', (new \DateTime('-'.$delay.' days'))->format('Y-m-d')
            ]);
        }

        // grid filtering conditions
        if ($this->disconfirm) {
            $query->andFilterWhere([
                'disconfirm' => 0,
            ]);
            $query->andWhere(['or',
                    ['<>', 'discount', 0],
                    ['<>', 'discomment', '']
                ]);
        }
        // grid filtering conditions
        if ($this->task) {
            $todo = Todo::find()->select('client')->andFilterWhere([
                'status' => 10,
            ]);
            $taskIDs = $todo->groupBy('client')->asArray()->column();
            $query->andWhere(['in', 'id', $taskIDs]);
        }

        if($searchArr || isset($ids)) {
            $or = ['or'];
            foreach ($searchArr as $searchIt) {
                $or[] = ['like', 'name', trim($searchIt)];
                $or[] = ['like', 'address', trim($searchIt)];
                $or[] = ['like', 'discomment', trim($searchIt)];
            }
            if (isset($ids)) {
                $or[] = ['in', 'id', $ids];
            }
            $query->andWhere($or);
        }

        return $dataProvider;
    }
}
