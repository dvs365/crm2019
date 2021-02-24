<?php
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'form-password_change', 'options' =>  ['class' => 'password_change']]); ?>
	<span class="error color_red"></span>
	<table>
		<tr>
			<td class="w180 lh-cancel418">Текущий пароль</td>
			<td class="w280">
				<?= $form->field($model, 'currentPassword', ['template' => "{input}"])->input('password', ['class' => 'mb10']) ?>	
			</td>
		</tr>
		<tr>
			<td class="w180 lh-cancel418">Новый пароль</td>	
			<td><?= $form->field($model, 'newPassword', ['template' => "{input}"])->input('password', ['class' => 'mb10']) ?></td>
		</tr>
		<tr>
			<td class="w180 lh-cancel418">Повторите пароль</td>
			<td><?= $form->field($model, 'newPasswordRepeat', ['template' => "{input}"])->input('password', ['class' => 'mb10']) ?></td>
		</tr>
		<tr>
			<td class="w180"></td>
			<td><input type="submit" class="btn right" name="pass-change" value="Сохранить"></td>
		</tr>
	</table>
<?php ActiveForm::end(); ?>