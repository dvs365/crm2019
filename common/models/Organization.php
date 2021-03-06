<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property int $client
 * @property string $name
 * @property string $valid
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
    const FORM_TOO = 70;
    const FORM_ZAO = 80;
    const FORM_GUP = 90;
    const FORM_GP = 100;
	const FORM_OAO = 110;
	const FORM_TSZ = 120;
	const FORM_TSN = 130;
	const FORM_UK = 140;
	
	const UNKNOWNNDS = 0;
    const WITHNDS = 10;
    const WITHOUTNDS = 20;
	
	const VALID = 1;
    const NO_VALID = 0;	


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
			['valid', 'in', 'range' => [self::VALID, self::NO_VALID]],
            ['phone','app\components\validators\PhoneValidator'],
			['mail', 'app\components\validators\MailValidator'],
            [['client', 'form', 'nds', 'number_mirror', 'inn', 'ogrn', 'kpp', 'payment', 'valid', 'bik'], 'integer'],

            ['form', 'in', 'range' => [self::FORM_OOO, self::FORM_AO, self::FORM_PAO, self::FORM_MUP, self::FORM_FGUP, self::FORM_IP, self::FORM_TOO, self::FORM_ZAO, self::FORM_GUP, self::FORM_GP, self::FORM_OAO, self::FORM_TSZ, self::FORM_TSN, self::FORM_UK]],
            ['nds', 'in', 'range' => [self::WITHNDS, self::WITHOUTNDS, self::UNKNOWNNDS]],
            [['name', 'jadds', 'fadds', 'director', 'bank'], 'string', 'max' => 255],
			['mail', 'trim'],
			['mail', 'email'],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client' => 'id']],
        ];
    }

    function getNdsLabels()
    {
        return [
			self::UNKNOWNNDS => 'Неизвестно',
            self::WITHNDS => 'С НДС',
            self::WITHOUTNDS => 'Без НДС',
        ];
    }

    function getNdsConst()
    {
        return [
			'unknownnds' => self::UNKNOWNNDS,
            'with' => self::WITHNDS,
            'without' => self::WITHOUTNDS,
        ];
    }

    function getFormLabels()
    {
        return [
            self::FORM_OOO => 'ООО',
			self::FORM_IP => 'ИП',
            self::FORM_AO => 'АО',
			self::FORM_GUP => 'ГУП',
			self::FORM_GP => 'ГП',
			self::FORM_ZAO => 'ЗАО',
            self::FORM_MUP => 'МУП',
            self::FORM_PAO => 'ПАО',
            self::FORM_TOO => 'ТОО',
            self::FORM_FGUP => 'ФГУП',
			self::FORM_OAO => 'OAO',
			self::FORM_TSZ => 'ТСЖ',
			self::FORM_TSN => 'ТСН',
			self::FORM_UK => 'УК',
        ];
    }

    function getFormLabel() {
        $forms = $this->getFormLabels();
        return isset($forms[$this->form]) ? $forms[$this->form] : '';
    }

	function getNdsLabel() {
        $nds = $this->getNdsLabels();
        return isset($nds[$this->nds]) ? $nds[$this->nds] : '';		
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
            'form' => 'Форма собственности',
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
			'valid' => 'Рабочая',
			'bik' => 'БИК',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Client::className(), ['id' => 'client']);
    }
	
    public function beforeSave($insert)
    {
		$this->mail = trim($this->mail);
		return parent::beforeSave($insert);
    }
}