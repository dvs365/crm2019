<?
use yii\helpers\Url;
?>
<?foreach ($todos as $todo):?>
    <div class="task_item">
        <table>
            <tr class="table_item">
                <td>
                    <form action="<?=Url::toRoute(['todo/deleteclient', 'id' => $todo->id])?>"  class="todoclientdelete" method="POST" onsubmit="send(this)">
                        <input type="checkbox" name="task" value="2">
                        <button class="checkbox deltodoclient" title="Закрыть дело"></button>
                    </form>
                </td>
                <td class="date"><?=date('d.m.y',strtotime($todo->date))?></td>
                <td <?=(!empty($todo->description))?' class="open_desc color_blue"':''?>><?=$todo->name?></td>
            </tr>
            <?if(!empty($todo->description)):?>
                <tr class="table_item table_item_hidden">
                    <td></td>
                    <td class="date">в <?=date('H:i',strtotime($todo->date))?></td>
                    <td><?=$todo->description?></td>
                </tr>
            <?endif;?>
        </table>
    </div>
<?endforeach;?>