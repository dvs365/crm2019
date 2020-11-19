<?
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?foreach ($todos as $todo):?>
	<?if (\Yii::$app->user->can('viewTodoUser') || $todo->user == Yii::$app->user->identity->id):?>
    <div class="task_item">
        <table>
            <tr class="table_item">
                <td>
					<?php $form = ActiveForm::begin(['action' => ['todo/closeclient', 'id' => $todo->id], 'options' => ['class' => 'todoclientdelete'], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
                        <input type="checkbox" name="task" value="2">
                        <button class="checkbox deltodoclient" title="Закрыть дело"></button>
                    <?php ActiveForm::end();?>
                </td>
                <td class="date"><a href="#" class="task_change_open" onClick="openChangeTask(this);"><?=date('d.m.y',strtotime($todo->date))?></a></td>
                <td><a href="<?=Url::to(['todo/view', 'id' => $todo->id])?>"><?=$todo->name?></a></td>
            </tr>
            <?if(!empty($todo->description)):?>
                <tr class="table_item tr_comment">
                    <td></td>
                    <td class="date">в <?=date('H:i',strtotime($todo->date))?></td>
                    <td><div class="task_comment"><?=$todo->description?><span class="task_comment_gradient pink color_blue">Весь комментарий <span class="dropdown"></span></span></div></td>
                </tr>
            <?endif;?>
        </table>
		<?= $this->render('_form_todo_up', [
			'todo' => $todo,
		]) ?>
    </div>
	<?endif;?>
<?endforeach;?>