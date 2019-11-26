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
            [['client', 'number_mirror'], 'integer'],
            ['number', 'validatePhone', 'skipOnEmpty'=>false],
            [['comment', 'number'], 'string', 'max' => 255],
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

    public function validatePhone($attribute, $params)
    {
        $int = preg_replace("/[^0-9]/", '', $attribute);

        if(!empty($int) && (mb_strlen($int) < 11 || mb_strlen($int) > 12)){
            echo '<script>alert("ssssssssssssss");</script>';
            $errorMsg = '11 или 12 цифр';
            $this->addError($attribute, $errorMsg);

        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }
}