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
            [['name','date'], 'required'],
            [['client'], 'integer'],
            [['date', 'dateto'], 'date', 'format' => 'php:d.m.Y'],
            [['time'], 'safe'],
            [['name', 'description', 'nameclient'], 'string', 'max' => 255],
       //     [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client' => 'id']],
        ];
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
            'nameclient' => 'Nameclient',
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

    public function setDateTimeFrom()
    {
        if ($this->date && $this->time)
        {
            return \DateTime::createFromFormat('d.m.Y H:i', $this->date . ' ' . $this->time)->format('Y-m-d H:i:s');
        }

        if ($this->date) {
            return \DateTime::createFromFormat('d.m.Y', $this->date)->format('Y-m-d 00:00:00');
        }

        return false;
    }

    public function setDateTimeTo()
    {
        if ($this->dateto) {
            return \DateTime::createFromFormat('d.m.Y', $this->dateto)->format('Y-m-d 23:59:59');
        }
        return false;
    }
}