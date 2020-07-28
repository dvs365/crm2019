<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
	<div class="pink_background wrap1">
		<div class="task">
		<h1>Просроченные дела</h1>
	<?foreach ($lastTodos as $lastTodo):?>
		<div class="task_item">
			<table class="w100p">
				<tr class="table_item">
					<td class="w70"><?=date('d.m',strtotime($lastTodo->dateto))?></td>
					<td class="w50">
						<form action="<?= Url::to(['todo/toclose', 'id' => $lastTodo->id])?>" class="toclose" method="POST" onsubmit="send(this)">
							<input type="checkbox" name="task" value="1">
							<button class="checkbox" title="Закрыть дело"></button>
						</form>
					</td>
					<td>
						<?= Html::a(Html::encode($lastTodo->name), ['view', 'id' => $lastTodo->id])?>
						<?if ($lastTodo->client):?>
						<span class="task_item_client"><?= Html::encode($lastTodo->client0['name'])?></span>
						<?endif;?>
					</td>
				</tr>
				<?if ($lastTodo->description):?>
				<tr class="table_item">
					<td></td>
					<td></td>
					<td><?= Html::encode($lastTodo->description)?></td>
				</tr>
				<?endif;?>
			</table>
		</div>
	<?endforeach;?>
		</div>
	</div>