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
            [['face'], 'integer'],
            [['mail'], 'string', 'max' => 255],
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
            'mail' => 'Mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFace0()
    {
        return $this->hasOne(Face::className(), ['id' => 'face']);
    }
}