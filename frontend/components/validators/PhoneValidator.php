<?php
namespace app\components\validators;

use yii\validators\Validator;
use common\models\Phoneface;
use common\models\Phoneclient;
use common\models\Organization;
use common\models\Face;

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
        $queryPhoneface = Phoneface::find()->where(['number_mirror' => $model->number_mirror]);
        $queryPhoneclient = Phoneclient::find()->where(['number_mirror' => $model->number_mirror]);
        $queryPhoneOrg = Organization::find()->where(['number_mirror' => $model->number_mirror]);
        if ($model->isNewRecord) {
            if ($queryPhoneface->exists()) {
                $model->addError($attribute, 'double1');
            }elseif ($queryPhoneclient->exists()) {
                $model->addError($attribute, 'double2');
            }elseif ($queryPhoneOrg->exists()) {
                $model->addError($attribute, 'double3');
            }
        } else {
            $modelsPhone = $queryPhoneclient->limit(2)->asArray()->all();
            $n = count($modelsPhone);
            if ($n === 1) {
                $dbModel = reset($modelsPhone);
                if ($model->id != $dbModel['id']){
                    $model->addError($attribute, $model->$attribute . '->' .$n.  ' double01');
                }
            } elseif ($n > 1) {
                $model->addError($attribute, $model->$attribute .'->'.$n .' double001');
            }
            $modelsPhone = $queryPhoneface->limit(2)->asArray()->all();
            $n = count($modelsPhone);
            if ($n === 1) {
                $dbModel = reset($modelsPhone);
                if ($model->id != $dbModel['id']){
                    $model->addError($attribute, $model->$attribute . 'double02');
                }
            } elseif ($n > 1) {
                $model->addError($attribute, $model->$attribute . 'double002');
            }
            $modelsPhone = $queryPhoneOrg->limit(2)->asArray()->all();
            $n = count($modelsPhone);
            if ($n === 1) {
                $dbModel = reset($modelsPhone);
                if ($model->id != $dbModel['id']){
                    $model->addError($attribute, $model->$attribute . 'double03');
                }
            } elseif ($n > 1) {
                $model->addError($attribute, $model->$attribute . 'double003');
            }
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