<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
	<div class="wrap4 wrap_work pink_background" data-work="2">
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
						<?=Html::a(Html::encode($lastTodo->client0['name'])?:'Собственное', ['view', 'id' => $lastTodo->id], ['class' => 'task_item_client'])?>
						<?=Html::tag('p', $lastTodo->name)?>
					</td>
				</tr>
				<?if($lastTodo->description):?>
				<tr class="table_item tr_comment">
					<td></td>
					<td></td>
					<td><?=Html::tag('div', Html::encode($lastTodo->description).Html::tag('span', 'Весь комментарий '.Html::tag('span', '', ['class' => 'dropdown']),['class' => 'task_comment_gradient pink color_blue']),['class' => 'task_comment'])?></td>
				</tr>
				<?endif;?>
			</table>
		</div>
	<?endforeach;?>
		</div>
	</div>