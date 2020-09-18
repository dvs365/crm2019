<?
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?
foreach ($comments as $comment10):
	$comment10Arr = array_reverse(explode('&^', $comment10->text));
	foreach ($comment10Arr as $comment10str):
		list($commentTime, $commentText) = explode('^&', $comment10str);
		$date = \DateTime::createFromFormat('Y-m-d', $commentTime);
		$dateComment = $commentTime ? ($date->format('Y') == date('Y'))?$date->format('d.m'):$date->format('d.m.Y') : '';
		?>
		<tr class="table_item">
			<td class="date color_grey this_year"><?=$dateComment?></td>
			<td><?=Html::encode($commentText)?></td>
		</tr><?
	endforeach;
endforeach;
