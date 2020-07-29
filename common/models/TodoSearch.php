<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * ClientSearch represents the model behind the search form of `common\models\Client`.
 */
class TodoSearch extends Todo
{


    public $search;
    public $statuses;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'status'], 'integer'],
            [['name', 'description', 'search'], 'safe'],
            ['statuses', 'each', 'rule' => ['integer']],
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
        $query = Todo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 5,
				'validatePage' => false,
			],			
        ]);

        $this->load($params);

        $searchArr = explode('|', $this->search);
		//echo '<pre>search = '; print_r($this->search); echo '</pre>';
        foreach ($searchArr as $searchKey => $searchIt) {
			if (mb_strlen($searchIt) < 4) {
                unset($searchArr[$searchKey]);
            }
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user' => \Yii::$app->user->can('user')? \Yii::$app->user->id : $this->user,
        ]);

        if($searchArr) {
            $or = ['or'];
            foreach ($searchArr as $searchIt) {
                $or[] = ['like', 'name', trim($searchIt)];
                $or[] = ['like', 'description', trim($searchIt)];
            }
            $query->andWhere($or);
        }
        $query->andWhere(['in', 'status', $this::CLOSE]);
		//echo '<pre>or = '; print_r($query); echo '</pre>';

        //$query->orderBy(['closed_at' => SORT_DESC]);
        return $dataProvider;
    }
}