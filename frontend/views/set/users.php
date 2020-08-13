<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<main>
	<div class="wrap1 control">
		<?=$this->render('_menu')?>
		<a href="<?=Url::toRoute(['set/signup'])?>" class="btn w200 right ml20">Добавить пользователя</a>
		<a href="settings-function-add.html" class="btn w200 right">Добавить функцию</a>    
		<div class="clear"></div>
	</div>
	<h1 class="wrap1">Список пользователей</h1>
	<div class="wrap_users_list">
		<table class="users_list">
			<tr>
				<th>ФИО</th>
				<th>Должность</th>
				<th>Статус</th>
				<th>Доступ</th>
			</tr>
			<?foreach ($users as $user):?>
			<tr>
				<td><?=Html::a(Html::encode($user->surnameNP), ['set/update', 'id' => $user->id])?></td>
				<td><?=Html::encode($user->position)?></td>
				<td><?=$user->statusLabel?></td>
				<?$roles = Yii::$app->authManager->getRolesByUser($user->id);?>
				<td><?=isset($roles['admin']) ? 'Расширенный' : 'Базовый'?></td>
			</tr>
			<?endforeach;?>
		</table>
	</div>
</main>