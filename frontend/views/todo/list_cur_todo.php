<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?foreach ($curTodos as $curTodo):?>
	<?$date1 = new DateTime($curTodo->date);?>
	<?$date2 = new DateTime($curTodo->dateto);?>
	<?$time1 = ($date1->format('Y-m-d') < $date2->format('Y-m-d')) ? new DateTime(date('Y-m-d', $datetime).' '.$date1->format('H:i')) : $date1?>
	<?$time2 = \Yii::$app->formatter->asDateTime(new DateTime(), 'php:Y-m-d H:i:s');?>
	<?$last = $time1->format('Y-m-d H:i:s') < $time2 ? true: false?>
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
<?$datetime1 = new DateTime(date('Y-m-d', $datetime))?>
<?$datetime2 = new DateTime()?>
<?if ($datetime1->format('Y-m-d') != $datetime2->format('Y-m-d')): ?>
	<script>
		var late = Number(document.getElementById("work_overdue_value").textContent.replace ( /[^\d.]/g, '' ));
		var cur = Number(<?=count($curTodos)?>);
		var all = late + cur;
		document.getElementById("work_value").textContent="(" + all + ")";
		document.getElementById("work_active_value").textContent="(" + cur + ")";
		
	</script>
<?endif;?>