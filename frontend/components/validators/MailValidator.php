<?php
namespace app\components\validators;

use yii\validators\Validator;
use common\models\Mailface;
use common\models\Mailclient;
use common\models\Organization;
use common\models\Face;

class MailValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'неверный формат';
    }

    public function validateAttribute($model, $attribute)
    {
        $queryMailclient = Mailclient::find()->where(['mail' => $model->mail]);
        $queryMailface = Mailface::find()->where(['mail' => $model->mail]);
        $queryMailOrg = Organization::find()->where(['mail' => $model->mail]);
		
		$faceIDs = Face::find()->where(['client' => $model->client])->select('id')->asArray()->column();
				
		if ($queryMailface->andWhere(['not in', 'face', $faceIDs])->exists()) {
			$model->addError($attribute, 'e-mail задублирован.');
		}
		elseif ($queryMailclient->andWhere(['<>', 'client', $model->client])->exists()) {
			$model->addError($attribute, 'e-mail задублирован.');
		}
		elseif ($queryMailOrg->andWhere(['<>', 'client', $model->client])->exists()) {
			$model->addError($attribute, 'e-mail задублирован.');
		}
    }
}