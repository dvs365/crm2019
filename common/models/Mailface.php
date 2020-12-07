<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mailface".
 *
 * @property int $id
 * @property int $face
 * @property string $mail
 *
 * @property Face $face0
 */
class Mailface extends \yii\db\ActiveRecord
{
	public $client;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailface';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			['mail', 'app\components\validators\MailValidator'],
            [['face'], 'integer'],
			['mail', 'trim'],
            //['mail', 'email'],
			[['client'], 'safe'],
            [['face'], 'exist', 'skipOnError' => true, 'targetClass' => Face::className(), 'targetAttribute' => ['face' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'face' => 'Face',
            'mail' => 'E-mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFace0()
    {
        return $this->hasOne(Face::className(), ['id' => 'face']);
    }
	
    public function beforeSave($insert)
    {
		$this->mail = trim($this->mail);
		return parent::beforeSave($insert);
    }
}