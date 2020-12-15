<?php
namespace frontend\models;
 
//use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
use app\base\Model;
 
class TransferClientForm extends Model
{
    public $userID;
	public $clientIDs;
	public $users;
	public $transfer;
   
    public function rules()
    {
        return [
			['userID', 'required'],
			['userID', 'integer'],
			['clientIDs', 'each', 'rule' => ['integer']],
			['users', 'checkIsArrayArrayID'],
			['transfer', 'string', 'max' => 255]
        ];
    }
 
    public function update()
    {
        if ($this->validate()) {
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				$this->clientIDs = array_diff($this->clientIDs, ['0']);
				$desclientClientIDs = \common\models\Desclient::find()->select('client')->where(['client' => $this->clientIDs])->asArray()->column();
				$desclientIns = array_diff($this->clientIDs, $desclientClientIDs);
				foreach ($desclientIns as $clientID) {
					$desclient = new \common\models\Desclient;
					$desclient->client = $clientID;
					$desclient->save();
				}
				\common\models\Client::updateAll(['user' => $this->userID, 'show' => ''], ['id' => $this->clientIDs]);
				\common\models\Desclient::updateAll(['transfer' => $this->transfer ?: date('Y-m-d H:i:s')], ['client' => $this->clientIDs]);
				foreach ($this->users as $userOld => $clientIDs) {
					\common\models\Todo::updateAll(['user' => $this->userID], ['client' => $clientIDs, 'user' => $userOld]);
				}
				$transaction->commit();
				return true;
			} catch (Exception $e) {
				$transaction->rollBack();
			}
        }
        return false;
    }
	
	public function checkIsArrayArrayID($attribute, $params)
	{
		$attribute = $this->$attribute;
		if (!is_array($attribute)) return false;
		
		foreach ($attribute as $id1 => $arrID){
			if (!is_int($id1) || !is_array($arrID)) return false;
			
			foreach ($arrID as $id2) {
				if (!is_int($id2)) return false;
			}
		}
		return true;
	}
}