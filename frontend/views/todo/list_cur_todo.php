<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?foreach ($curTodos as $curTodo):?>
	<? $time1 = (date('d m Y H:i',strtotime($curTodo->date)));?>
	<? $time2 = \Yii::$app->formatter->asDateTime(new DateTime(), 'php:d m Y H:i');?>
	<?$last = $time1 < $time2 ? true: false?>
	<div class="task_item">
		<table class="w100p">
			<tr class="table_item">
				<td class="w70<?=($last)?' color_red':''?>"><?= date('H:i',strtotime($curTodo->date))?></td>
				<td class="w50">
					<form action="<?= Url::to(['todo/toclose', 'id' => $curTodo->id])?>" class="toclose" method="POST" onsubmit="send(this)">
						<input type="checkbox" name="task" value="1">
						<button class="checkbox" title="Закрыть дело"></button>
					</form>
				</td>
				<td>
					<?=Html::a(isset($clientTodoName[$curTodo->client]) ? Html::encode($clientTodoName[$curTodo->client]) : 'Собственное', ['view', 'id' => $curTodo->id], ['class' => 'task_item_client'.(($last)?' color_red':'')])?> 
					<?=Html::tag('p', $curTodo->name)?>
				</td>
			</tr>
			<?if($curTodo->description):?>
			<tr class="table_item">
				<td></td>
				<td></td>
				<td><?=Html::tag('div', Html::encode($curTodo->description).Html::tag('span', 'Весь комментарий '.Html::tag('span', '', ['class' => 'dropdown']),['class' => 'task_comment_gradient color_blue']),['class' => 'task_comment'])?></td>
			</tr>
			<?endif;?>
		</table>
	</div>
<?endforeach;?>