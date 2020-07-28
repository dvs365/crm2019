<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?foreach ($curTodos as $curTodo):?>
	<div class="task_item">
		<table class="w100p">
			<tr class="table_item">
				<td class="w70"><?= date('H:i',strtotime($curTodo->date))?></td>
				<td class="w50">
					<form action="<?= Url::to(['todo/toclose', 'id' => $curTodo->id])?>" class="toclose" method="POST" onsubmit="send(this)">
						<input type="checkbox" name="task" value="1">
						<button class="checkbox" title="Закрыть дело"></button>
					</form>
				</td>
				<td><?= Html::a(Html::encode($curTodo->name), ['view', 'id' => $curTodo->id])?> 
				<?if ($curTodo->client):?>
				<span class="task_item_client"><?= Html::encode($curTodo->client0['name'])?></span></td>
				<?endif;?>
			</tr>
			<tr class="table_item">
				<td></td>
				<td></td>
				<td><?= Html::encode($curTodo->description)?></td>
			</tr>
		</table>
	</div>
<?endforeach;?>