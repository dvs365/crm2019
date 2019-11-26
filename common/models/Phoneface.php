<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phoneface".
 *
 * @property int $id
 * @property int $face
 * @property int $number
 * @property int $number_mirror
 * @property string $comment
 *
 * @property Face $face0
 */
class Phoneface extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phoneface';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['face', 'number', 'number_mirror'], 'integer'],
            [['comment'], 'string', 'max' => 255],
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
            'number' => 'Number',
            'number_mirror' => 'Number Mirror',
            'comment' => 'Comment',
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
