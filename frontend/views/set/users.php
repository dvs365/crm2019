<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<main>
	<div class="wrap1 control">
		<?=$this->render('_menu')?>
		<a href="<?=Url::toRoute(['set/signup'])?>" class="btn w200 right ml20">Добавить пользователя</a>
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
				<?$roles = Yii::$app->authManager->getRolesByUser($user->id);?>
				<?if ((isset($roles['user']) && \Yii::$app->user->can('addUpUser')) || (isset($roles['admin']) && \Yii::$app->user->can('addUpAdmin'))):?>
					<tr <?=!$user->status?'class="user_archive"':''?>>
						<td><?=Html::a(Html::encode($user->surnameNP), ['set/update', 'id' => $user->id])?></td>
						<td><?=Html::encode($user->position)?></td>
						<td><?=$user->statusLabel?></td>
						<td><?=isset($roles['admin']) ? 'Расширенный' : 'Базовый'?></td>
					</tr>
				<?endif;?>
			<?endforeach;?>
		</table>
	</div>
</main>