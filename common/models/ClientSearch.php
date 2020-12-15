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
    public $statuses;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'status', 'discount', 'disconfirm', 'update_u', 'update_a', 'permonth'], 'integer'],
            [['name', 'address', 'discomment', 'update', 'search', 'task'], 'safe'],
            ['statuses', 'each', 'rule' => ['integer']],
        ];
    }

    function getStatusLabels()
    {
        return [
            self::TARGET => 'Потенциальные',
            self::LOAD => 'Рабочие',
            self::REJECT => 'Отказные'
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
		$whereFlag = false;
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => \Yii::$app->controller->action->id == 'index' ? 20 : 0,
				'validatePage' => false,
			],			
        ]);
		
        $this->load($params);
		if (\Yii::$app->controller->action->id == 'transfer') {
			if (!$this->search && !$this->user && !$this->status){
				$query->andWhere(['id' => '0']);
				return $dataProvider;
			}
		}
        $searchArr = explode('|', $this->search);
        list($mails, $phones) = [[],[]];
		$ids = [];
        foreach ($searchArr as $searchKey => $searchIt) {
            $searchPhone = preg_replace("/[^0-9]/","",$searchIt);
            if (strpos($searchIt, '@') && mb_strlen($searchIt) > 3) {
                $mails[] = trim($searchIt);
                unset($searchArr[$searchKey]);
            }elseif (mb_strlen($searchPhone) > 3) {
                if (mb_strlen($searchPhone) == 11 && ($searchPhone[0] == 7 || $searchPhone[0] == 8)){
                    $searchPhone = substr($searchPhone, 1);
                }
                $phones[] = strrev($searchPhone);
                unset($searchArr[$searchKey]);
            }elseif (mb_strlen($searchIt) < 3) {
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
		if (!empty($_GET['role']) || (empty($_GET['role']) && !$this->search)) {
			$user = \Yii::$app->user->identity;
			if (!empty($user->managers)) {
				$user->managers = array_diff(explode(',', $user->managers), ['all']);
			}

			$query->andFilterWhere([
				'user' => $user->managers ? array_merge($user->managers, [\Yii::$app->user->id]) : (\Yii::$app->user->can('user') ? \Yii::$app->user->id : $this->user),
			]);
		} else {
			$query->andFilterWhere([
				'user' => $this->user,
			]);
		}
		
        if ($this->permonth) {
			$whereFlag = true;
            $delay = (int)$this->permonth * 30;
            $query->andWhere([
                '>', 'show_u', (new \DateTime('-'.$delay.' days'))->format('Y-m-d')
            ]);
        }

        // grid filtering conditions
        if ($this->disconfirm) {
			$whereFlag = true;
            $query->andFilterWhere([
                'disconfirm' => 0,
            ]);
			//именить базу UPDATE `client` SET `disconfirm` = 1 WHERE discount = 0 и discomment = ''
            $query->andWhere(['or',
                    ['<>', 'discount', 0],
                    ['<>', 'discomment', '']
                ]);
        }
        // grid filtering conditions
        if ($this->task) {
			$whereFlag = true;
            $todo = Todo::find()->select('client')->andFilterWhere([
                'status' => 10,
            ]);
            $taskIDs = $todo->groupBy('client')->asArray()->column();
            $query->andWhere(['in', 'id', $taskIDs]);
        }

        if($searchArr || !empty($ids)) {
			$whereFlag = true;
            $or_ = ['or'];
            foreach ($searchArr as $searchIt) {
				$words = explode(' ', $searchIt);
				$and = ['and'];
				foreach ($words as $word) {
					if (mb_strlen($word , 'UTF-8') < 3) continue;
					$or = ['or'];
					$or[] = ['like', 'name', trim($word)];
					$or[] = ['like', 'address', trim($word)];
					$or[] = ['id' => Organization::find()->andWhere(['like', 'name', trim($word)])->select('client')->asArray()->column()];
					$or[] = ['id' => Face::find()->andWhere(['like', 'fullname', trim($word)])->select('client')->asArray()->column()];					
					$and[] = $or;
				}
				$or_[] = $and;
            }
            if (!empty($ids)) {
                $or_[] = ['in', 'id', $ids];
            }
            $query->andWhere($or_);
        }
        if($this->statuses) {
			$whereFlag = true;
            $query->andWhere(['in', 'status', $this->statuses]);
        }
		if (!$whereFlag && $this->search) {
			$query->andWhere(['id' => '0']);
		}

        $query->orderBy(['show' => SORT_DESC]);
		
        return $dataProvider;
    }
}
