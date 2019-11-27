<?php
namespace app\components\validators;

use yii\validators\Validator;
use common\models\Phoneface;
use common\models\Phoneclient;
use common\models\Organization;

class PhoneValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'the phone is not correct.';
    }

    public function validateAttribute($model, $attribute)
    {
        $int = preg_replace("/[^0-9]/", '', $model->$attribute);
        $strlen = mb_strlen($int);
        if (!in_array($strlen, [0,11,12])){
            $model->addError($attribute, $this->message);
        }elseif ($strlen == 11 && mb_substr($int,0,1,'utf-8') == '8'){
            $int = substr_replace($int, '7',0,1);
        }

        $model->number_mirror = strrev($int);
        if (Phoneface::find()->where(['number_mirror' => $model->number_mirror])->exists()) {
            $model->addError($attribute, 'double');
        }elseif (Phoneclient::find()->where(['number_mirror' => $model->number_mirror])->exists()) {
            $model->addError($attribute, 'double');
        }elseif (Organization::find()->where(['number_mirror' => $model->number_mirror])->exists()) {
            $model->addError($attribute, 'double');
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
var rev = '';  
var arr = [];
var num = value.replace(/\D+/g,'');
var i = num.length;
if($.inArray(i, [0,11,12]) === -1){
    messages.push($message);
}
if(i == 11 && num[0] == '8'){
    arr = num.split("");
    arr[0] = '7';
    rev = arr.reverse().join("");
}

JS;

    }
}