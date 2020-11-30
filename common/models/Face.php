<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "face".
 *
 * @property int $id
 * @property int $client
 * @property string $fullname
 * @property string $position
 *
 * @property Client $client0
 * @property Mailface[] $mailfaces
 * @property Phoneface[] $phonefaces
 */
class Face extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'face';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client','main'], 'integer'],
            [['fullname', 'position'], 'string', 'max' => 255],
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
            'fullname' => 'ФИО',
            'position' => 'Должность',
			'main' => 'Основной',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailfaces()
    {
        return $this->hasMany(Mailface::className(), ['face' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonefaces()
    {
        return $this->hasMany(Phoneface::className(), ['face' => 'id']);
    }
}