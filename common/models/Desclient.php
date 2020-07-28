<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "desclient".
 *
 * @property int $id
 * @property int $client
 * @property string $reject
 * @property string $transfer
 *
 * @property Client $client0
 */
class Desclient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desclient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client'], 'required'],
            [['client'], 'integer'],
            [['reject', 'transfer'], 'string', 'max' => 255],
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
            'reject' => 'Reject',
            'transfer' => 'Transfer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }
}
