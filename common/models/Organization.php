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
    const FORM_OOO = 10;
    const FORM_AO = 20;
    const FORM_PAO = 30;
    const FORM_MUP = 40;
    const FORM_FGUP = 50;
    const FORM_IP = 60;


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
            ['phone','app\components\validators\PhoneValidator'],
            [['client', 'form', 'nds', 'phone', 'mail', 'inn', 'ogrn', 'kpp', 'payment'], 'integer'],

            ['form', 'in', 'range' => [self::FORM_OOO, self::FORM_AO, self::FORM_PAO, self::FORM_MUP, self::FORM_FGUP, self::FORM_IP]],
            ['nds', 'in', 'range' => [0, 1]],
            [['name', 'jadds', 'fadds', 'director', 'bank'], 'string', 'max' => 255],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client' => 'id']],
        ];
    }

    function getFormLabels() {
        return [
            self::FORM_OOO => 'ООО',
            self::FORM_AO => 'АО',
            self::FORM_PAO => 'ПАО',
            self::FORM_MUP => 'МУП',
            self::FORM_FGUP => 'ФГУП',
            self::FORM_IP => 'ИП'
        ];
    }

    function getFormLabel() {
        $forms = $this->getFormLabels();
        return isset($forms[$this->form]) ? $forms[$this->form] : '';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'name' => 'Наименование',
            'form' => 'Form',
            'jadds' => 'Юридический адрес',
            'fadds' => 'Фактический адрес',
            'director' => 'ФИО директора',
            'nds' => 'НДС',
            'phone' => 'Телефон',
            'mail' => 'E-mail',
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'kpp' => 'КПП',
            'payment' => 'Расчётный счёт',
            'bank' => 'Банк',
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
