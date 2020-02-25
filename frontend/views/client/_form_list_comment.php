<?
use yii\helpers\Url;
?>
<?foreach ($comments as $comment):?>
    <?
    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $comment->date);
    $dateComment = ($date->format('Y') == date('Y'))?$date->format('d.m'):$date->format('d.m.Y');
    ?>
    <tr class="table_item">
        <td class="date color_grey this_year"><?=$dateComment?></td>
        <td><?=$comment->text?></td>
    </tr>
<?endforeach;?>
