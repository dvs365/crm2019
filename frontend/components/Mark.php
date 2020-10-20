<?php

namespace frontend\components;

use common\models\User;
use yii\base\Component;

class Mark extends Component {

    public function birthday($day = 7) {
		$dateFrom = new \DateTime();
        $dateTo = new \DateTime('+'.$day.' days');
		$models = User::findBySql('SELECT * FROM `user` WHERE DATE_FORMAT(birthday,"%m%d") >= '.$dateFrom->format('md').' AND DATE_FORMAT(birthday,"%m%d") <= '.$dateTo->format('md').'')->count();
        return $models;
    }
}