<?php

use yii\helpers\Html;
use frontend\assets\TodoAsset;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дела:' . \common\models\User::findOne(Yii::$app->user->identity->id)->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
TodoAsset::register($this);
?>
<main>
	<div class="task left">
		<div class="wrap1 control">
			<?=$this->render('menu')?>
		</div>
		<?if (empty($status) || $status == common\models\Todo::OPEN):?>
		<?=$this->render('_form', [
			'model' => new common\models\Todo,
			'action' => ['todo/create'],
			'clients' => $clients,
			'users' => $users,
		])?>
		<?endif;?>
	</div>
	<?if(\Yii::$app->user->can('viewTodoUser')):?>
	<?$userModel = Yii::$app->user->identity; $managerIDs = array_diff(explode(',', $userModel->managers), ['all', Yii::$app->user->identity->id])?>
	<?=$this->render('_form_user', [
		'model' => new common\models\Todo,
		'user' => common\models\User::find()->where(['id' => $managerIDs])->all(),
		'userID' => $userID,
		'action' => ['todo/index', 'status' => $status],
	])?>
	<?endif;?>
	<div class="clear"></div>
	<?if (empty($status) || $status == common\models\Todo::OPEN):?>	
		<?= Html::a('На неделю', ['todo/toweek'], ['class' => 'week_works__link'])?>
		<?=$this->render('_form_date', [
			'model' => new common\models\Todo,
			'action' => ['todo/index', 'status' => $status],
		])?>
		<div class="task" id="act-task">
				<?=$this->render('list_cur_todo', [
					'curTodos' => $todoCur,
					'status' => $status,
				])?>
		</div>
	<?endif;?>
	<?if (!empty($status) && $status == common\models\Todo::CLOSE):?>	
		<?=$this->render('list_close_todo', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
		])?>
	<?endif;?>
	<?if (empty($status) || $status == common\models\Todo::LATE):?>
		<?=$this->render('list_last_todo', [
			'lastTodos' => $todoLate,
		])?>
	<?endif;?>
</main>
