<?php
use yii\helpers\Html;
use frontend\assets\TodoAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Client */
\yii\web\YiiAsset::register($this);
TodoAsset::register($this);
?>
<main>
	<div class="task wrap1">
		<div class="about"><h1><?=Html::encode($todo->name)?></h1><span class="manager color_grey"><?= $todo->statusLabel?></span></div>
		<?=($todo->client0)? Html::a(Html::encode($todo->client0['name']), ['client/view', 'id' => $todo->client]) : ''?>
	</div>
	<div class="wrap1 control">
		<a href="<?=Url::to(['todo/index'])?>" class="arrow_left"></a><span class="color_blue" id="open-add-work">Изменить</span>
		<?if ($todo->status == $todo::OPEN):?>
		<?= Html::a('В закрытые', ['todo/toclose', 'id' => $todo->id])?>
		<?endif;?>
	</div>

	<div class="task">
		<div class="task_item wrap1">
			<?if ($todo->description):?>
			<p>Комментарий: <?=Html::encode($todo->description)?></p>
			<?endif;?>
		</div>
		<div class="task_item wrap1">
			<p>Начало: <?=Html::encode(date('d.m.y в H:i',strtotime($todo->date)))?></p>
			<p>Завершение: <?=Html::encode(date('d.m.y',strtotime($todo->dateto)))?></p>
		</div>
		<div class=" task_item wrap1">
			<p>Поставил: <?=($todo->created_id)?Html::encode($todo->createID->surnameNP):''?></p>
			<p>Исполнил: <?=($todo->status == $todo::CLOSE)?Html::encode($todo->closeID->surnameNP):''?></p>
		</div>

		<div id="form-work">
			<table class="w100p">
				<tr>
					<td class="w120 f128">
						Редакция
					</td>
					<td>
						<?=$this->render('_form_view', [
							'model' => $todo,
							'clients' => $clients,
							'action' => ['todo/update', 'id' => $todo->id],
						])?>
						<div class="clear"></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</main>