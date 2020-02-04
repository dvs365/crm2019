<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property int $user
 * @property string $name
 * @property string $address
 * @property string $website
 * @property int $status
 * @property int $discount
 * @property int $disconfirm
 * @property string $discomment
 * @property string $update
 * @property int $update_u
 * @property int $update_s
 * @property int $update_e
 *
 * @property User $user0
 * @property Face[] $faces
 * @property Mailclient[] $mailclients
 * @property Organization[] $organizations
 * @property Phoneclient[] $phoneclients
 */
class Client extends \yii\db\ActiveRecord
{
    const TARGET = 10;
    const LOAD = 20;
    const REJECT = 30;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],

            [['name', 'address', 'website', 'discomment'], 'string', 'max' => 255],
            [['user', 'disconfirm'], 'integer'],
            [['update'], 'safe'],

            [['user'], 'default', 'value' => null],
            ['user', 'filter', 'filter' => function($value){
                return is_null($value) ? null : intval($value);
            }],

            ['discount', 'default', 'value' => 0],
            ['discount', 'integer', 'min' => 0, 'max' => 99],
            ['disconfirm', 'filter', 'filter' => 'intval'],

            ['status', 'default', 'value' => self::TARGET],
            ['status', 'in', 'range' => [self::TARGET, self::LOAD, self::REJECT]],

            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    function getStatusLabels()
    {
        return [
           self::TARGET => 'Потенциальный',
           self::LOAD => 'Рабочий',
           self::REJECT => 'Отказной'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'Менеджер',
            'name' => 'Клиент',
            'address' => 'Адрес доставки',
            'website' => 'Сайт',
            'status' => 'Статус клиента',
            'discount' => 'Скидка',
            'disconfirm' => 'Принять',
            'discomment' => 'Комментарий к скидке',
            'update' => 'Update',
            'update_u' => 'Update U',
            'update_s' => 'Update S',
            'update_e' => 'Update E',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaces()
    {
        return $this->hasMany(Face::className(), ['client' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailclients()
    {
        return $this->hasMany(Mailclient::className(), ['client' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::className(), ['client' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneclients()
    {
        return $this->hasMany(Phoneclient::className(), ['client' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTodos()
    {
        return $this->hasMany(Todo::className(), ['client' => 'id']);
    }
}