<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BirthdayAsset;

BirthdayAsset::register($this);
?>

<main>
	<div class="wrap4">
		<div class="control left">
			<?=$this->render('_menu')?>
		</div>
		<div class="control_btn w460">
			<a href="<?=Url::toRoute(['set/signup'])?>" class="btn w220 ml20">Добавить пользователя</a>
			<div class="clear"></div>
		</div>
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
	<h2 class="f17 mb20">Календарь событий</h2>
	<div class="wrap_users_list">
		<table id="calendarBig">
			<thead>
				<tr><td></td><td></td><td></td></tr>
			</thead>
			<tbody>
				<?$month = [
					'1' => 'Январь', '2' => 'Февраль', '3' => 'Март', '4' => 'Апрель', '5' => 'Май', '6' => 'Июнь',
					'7' => 'Июль', '8' => 'Август', '9' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь'
				];
					$m = 0;
				?>
				<?for ($i=1; $i <= 4; $i++):?>
				<tr>
					<?for ($j=1; $j <= 3; $j++):?>
					<td>
						<table data-m="<?=$m++?>">
							<thead>
								<tr><td colspan="7"><?=$month[$m]?></td></tr>
								<tr><td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td>Сб</td><td>Вс</td></tr>
							</thead>
							<tbody></tbody>
						</table>
					</td>
					<?endfor;?>
				</tr>
				<?endfor;?>				
			</tbody>
		</table>	
		<div id="calendarTable">
			<?foreach ($users as $user):?>
				<?if ($user->birthday):?>
				<?$date = new DateTime($user->birthday);?>
				<div data-dd="<?=$date->format('j')?>" data-mm="<?=$date->format('n')?>" data-text="День рождения <?=$user->surnameNP?>"></div>
				<?endif;?>
			<?endforeach;?>
		</div>
	</div>
</main>