<?php


namespace common\models;

use Yii;

class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'client', 'date', 'text'], 'required'],
            [['user', 'client'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 2990],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'client' => 'Client',
            'text' => 'Text',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }

    public function beforeSave($insert)
    {
        $this->date = \DateTime::createFromFormat('d.m.Y H:i:s', $this->date)->format('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
}