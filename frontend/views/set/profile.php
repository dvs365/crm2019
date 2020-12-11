<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Настройки:' . \common\models\User::findOne(Yii::$app->user->identity->id)->surnameNP;
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
	<?if (\Yii::$app->user->can('admin')):?>
	<div class="wrap1 control">
		<?=$this->render('_menu')?>
	</div>
	<?endif;?>
	<h1 class="wrap1">Данные</h1>
	<div class="settings">
		<table class="wrap1 w100p lh36">
			<tr>
				<td class="w180">ФИО</td>
				<td><?=$user->surname.' '.$user->name.' '.$user->patronymic?></td>
			</tr>
			<tr>
				<td class="w180">Должность</td>
				<td><?=$user->position?></td>
			</tr>
			<tr>
				<td class="w180">Доступ</td>
				<?$roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);?>
				<td><?=isset($roles['admin']) ? 'Расширенный' : 'Базовый'?></td>
			</tr>
			<tr>
				<td class="w180">E-mail</td>
				<td><?=preg_replace("/([a-z0-9]{1})(.*?)([a-z0-9]{1}@...)/ism", "$1***$3", $user->email);?></td>
			</tr>
		</table>
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
	</div>
</main>