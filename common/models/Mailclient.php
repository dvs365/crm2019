<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mailclient".
 *
 * @property int $id
 * @property int $client
 * @property string $mail
 *
 * @property Client $client0
 */
class Mailclient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailclient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			['mail', 'app\components\validators\MailValidator'],
            [['client'], 'integer'],
			['mail', 'trim'],
			['mail', 'email'],
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
            'client' => 'Client',
            'mail' => 'Mail',
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
		$this->mail = trim($this->mail);
		return parent::beforeSave($insert);
    }	
}
