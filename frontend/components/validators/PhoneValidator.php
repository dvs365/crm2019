<?php
namespace app\components\validators;

use yii\validators\Validator;
use common\models\Phoneface;
use common\models\Phoneclient;
use common\models\Organization;
use common\models\Face;

class PhoneValidator extends Validator
{
    private $messageFormat = 'неверный формат';
	private $messageDouble = 'телефон задублирован';
	
    public function init()
    {
        parent::init();
		$this->message = '';
    }

    public function validateAttribute($model, $attribute)
    {
        $int = preg_replace("/[^0-9]/", '', $model->$attribute);
        $strlen = mb_strlen($int);
        if (!in_array($strlen, [0,11,12])){
            $model->addError($attribute, $this->messageFormat);
        }elseif ($strlen == 11 && mb_substr($int,0,1,'utf-8') == '8'){
            $int = substr_replace($int, '7',0,1);
        }

		$model->number_mirror = strrev($int);
		if ($model->number_mirror) {
			$queryPhoneclient = Phoneclient::find()->where(['number_mirror' => $model->number_mirror]);
			$queryPhoneface = Phoneface::find()->where(['number_mirror' => $model->number_mirror]);
			$queryPhoneOrg = Organization::find()->where(['number_mirror' => $model->number_mirror]);
			
			$faceIDs = Face::find()->where(['client' => $model->client])->select('id')->asArray()->column();
					
			if ($queryPhoneface->andWhere(['not in', 'face', $faceIDs])->exists()) {
				$model->addError($attribute, $this->messageDouble);
			}
			elseif ($queryPhoneclient->andWhere(['<>', 'client', $model->client])->exists()) {
				$model->addError($attribute, $this->messageDouble);
			}
			elseif ($queryPhoneOrg->andWhere(['<>', 'client', $model->client])->exists()) {
				$model->addError($attribute, $this->messageDouble);
			}
		}
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->messageFormat, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $message2 = json_encode($this->messageDouble, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return <<<JS
var rev = '';  
var arr = [];
var num = value.replace(/\D+/g,'');
var findText = ~value.replace(/[a-zа-яёА-ЯЁ]/g,'@').indexOf('@');
var i = num.length;
if($.inArray(i, [0,11,12]) === -1){
    messages.push($message);
}
var currentphone = num;

if(i == 11 && num[0] == '8'){
    arr = num.split("");
    arr[0] = '7';
    rev = arr.reverse().join("");
    currentphone = arr.join("");
}

let phones =  document.getElementsByClassName("phone_number");
var cnt = 0;

for (var i = 0; i < phones.length; i++){

    num8 = phones[i].value.replace(/\D+/g,'');
    num8cnt = num8.length;
    phone = num8;
    if(num8cnt == 11 && num8[0] == '8'){
        arrnum8 = num8.split("");
        arrnum8[0] = '7';
        phone = arrnum8.join("");
        
    }

}
if(findText){
    messages.push($message);
}
if(cnt > 1){
    messages.push($message2);
}
JS;

    }
}