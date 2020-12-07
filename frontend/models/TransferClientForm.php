<?php
namespace frontend\models;
 
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;
 
class TransferClientForm extends Model
{
    public $userID;
	public $clientIDs;
	public $users;
	public $transfer;
   
    public function rules()
    {
        return [
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
				\common\models\Client::updateAll(['user' => $this->userID], ['id' => $this->clientIDs]);
				\common\models\Desclient::updateAll(['transfer' => $this->transfer], ['client' => $this->clientIDs]);
				foreach ($this->users as $userOld => $clientIDs) {
					\common\models\Todo::updateAll(['user' => $this->userID], ['client' => $clientIDs, 'user' => $userOld]);
				}
				$transaction->commit();
				return true;
			} catch (Exception $e) {
				$transaction->rollBack();
			}
        } else {
            return false;
        }
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