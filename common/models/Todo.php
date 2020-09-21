<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "todo".
 *
 * @property int $id
 * @property int $client
 * @property string $name
 * @property string $description
 * @property string $nameclient
 * @property string $date
 * @property string|null $dateto
 *
 * @property Client $client0
 */
class Todo extends \yii\db\ActiveRecord
{
    const OPEN = 10;
    const CLOSE = 20;
	const LATE = 30;
	const SCENARIO_TOCLOSE = 'toclose';


    public $time;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['client', 'status', 'user', 'closed_id', 'created_id'], 'integer'],
            [['date', 'dateto'], 'date', 'format' => 'php:d.m.Y', 'except' => self::SCENARIO_TOCLOSE],
            [['time'], 'safe'],
            [['name'], 'string', 'max' => 255],
			[['description'], 'string', 'max' => 10000],
       //     [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client' => 'id']],
        ];
    }

    function getStatusLabels()
    {
        return [
           self::OPEN => 'Активное',
           self::CLOSE => 'Закрытое',
        ];
    }

    function getStatusLabel()
    {
        $statuses = $this->getStatusLabels();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }	
	
	
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'name' => 'Name',
            'description' => 'Description',
            'date' => 'Date',
            'dateto' => 'Dateto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }

    public function getCloseID()
    {
        return $this->hasOne(User::className(), ['id' => 'closed_id']);
    }	

    public function getCreateID()
    {
        return $this->hasOne(User::className(), ['id' => 'created_id']);
    }
	
    public function beforeSave($insert)
    {
		if (strtotime($this->dateto) < strtotime($this->date)) {
			$this->dateto = $this->date;
		}
		
		if ($this->scenario !== $this::SCENARIO_TOCLOSE) {
			$this->date = \DateTime::createFromFormat('d.m.Y H:i', $this->date . ' ' . $this->time)->format('Y-m-d H:i:s');
			$this->dateto = \DateTime::createFromFormat('d.m.Y', $this->dateto)->format('Y-m-d 23:59:59');
		}
        return parent::beforeSave($insert);
    }
}