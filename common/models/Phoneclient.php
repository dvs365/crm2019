<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phoneclient".
 *
 * @property int $id
 * @property int $client
 * @property int $number
 * @property int $number_mirror
 * @property string $comment
 *
 * @property Client $client0
 */
class Phoneclient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phoneclient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['number','app\components\validators\PhoneValidator'],
            [['client', 'number_mirror'], 'integer'],
            [['comment'], 'string', 'max' => 255],
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
            'number' => 'Number',
            'number_mirror' => 'Number Mirror',
            'comment' => 'Comment',
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