<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property int $client
 * @property string $address
 *
 * @property Client $client0
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client'], 'required'],
            [['client'], 'integer'],
            [['address'], 'string', 'max' => 2000],
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
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Client0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }
}