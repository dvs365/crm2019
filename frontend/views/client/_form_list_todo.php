<?
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?foreach ($todos as $todo):?>
    <div class="task_item">
        <table>
            <tr class="table_item">
                <td>
					<?php $form = ActiveForm::begin(['action' => ['todo/deleteclient', 'id' => $todo->id], 'options' => ['class' => 'todoclientdelete'], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
                        <input type="checkbox" name="task" value="2">
                        <button class="checkbox deltodoclient" title="Закрыть дело"></button>
                    <?php ActiveForm::end();?>
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