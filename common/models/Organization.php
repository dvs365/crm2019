<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property int $client
 * @property string $name
 * @property int $form
 * @property string $jadds
 * @property string $fadds
 * @property string $director
 * @property int $nds
 * @property int $phone
 * @property int $mail
 * @property int $inn
 * @property int $ogrn
 * @property int $kpp
 * @property int $payment
 * @property string $bank
 *
 * @property Client $client0
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client', 'director', 'nds', 'phone', 'mail', 'inn', 'ogrn', 'kpp', 'payment', 'bank'], 'required'],
            [['client', 'form', 'nds', 'phone', 'mail', 'inn', 'ogrn', 'kpp', 'payment'], 'integer'],
            [['name', 'jadds', 'fadds', 'director', 'bank'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'form' => 'Form',
            'jadds' => 'Jadds',
            'fadds' => 'Fadds',
            'director' => 'Director',
            'nds' => 'Nds',
            'phone' => 'Phone',
            'mail' => 'Mail',
            'inn' => 'Inn',
            'ogrn' => 'Ogrn',
            'kpp' => 'Kpp',
            'payment' => 'Payment',
            'bank' => 'Bank',
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
