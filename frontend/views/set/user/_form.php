<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' =>  ['class' => 'settings'], 'fieldConfig' => ['enableLabel' => false]]); ?>
        <table class="wrap1 w100p">
            <tr>
                <td class="w180">Фамилия</td>
                <td><?= $form->field($model, 'surname', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Имя</td>
                <td><?= $form->field($model, 'name', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Отчество</td>
                <td><?= $form->field($model, 'patronymic', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Должность</td>
                <td><?= $form->field($model, 'position', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">E-mail</td>
                <td><?= $form->field($model, 'email', ['template' => "{input}"])->input('email', ['class' => 'mb10']) ?></td>
            </tr>
            <tr>
                <td class="w180">Телефон</td>
                <td><?= $form->field($model, 'phone', ['template' => "{input}"])->input('text', ['class' => 'mb10']) ?></td>
            </tr>
			<tr>
				<td class="w180 cl360">Статус пользователя</td>
				<td class="settings_user">
					<label class="w160 left">
						<input type="radio" name="status-user" value="1" checked>
						<span class="radio"></span>
						Активный
					</label>
					<label class="w160 left">
						<input type="radio" name="status-user" value="2">
						<span class="radio"></span>
						Архивный
					</label>
					<div class="clear wrap3"></div>
					<div ID="status-archive">
						<p>У пользователя <span ID="clients_col">422</span> клиента. Выберите для них новых пользователей</p>
						<div ID="distribution" class="wrap_select">
							<label><span class="user">Пользователь:</span>
								<span ID="choise_user" class="select">
									<span class="users_choised"></span>
									<span class="dropdown"></span>
									<span class="choise_user">
										<select name="manager[]" multiple>
											<option value="1">Кириллов Н.Н.</option>
											<option value="2">Петрова О.И.</option>
											<option value="3">Перепелов О.О.</option>
											<option value="4">Иванов Н.Н.</option>
											<option value="5">Сидоров О.О.</option>
										</select>
									</span>
								</span>
							</label>
							<p>Клиенты будут распределены по следующим пользователям: <span class="users_choised"></span></p>
						</div>
					</div>
				</td>
			</tr>			
            <?if(\Yii::$app->user->can('addUpUser') && \Yii::$app->user->can('addUpAdmin')){?>
            <tr>
                <td class="w180 cl360">Право доступа</td>
                <td class="settings_user">

                    <?= $form->field($model, 'access', ['template' => "{input}"])->radioList(['1' => ' Базовый', '2' => ' Расширенный'],[
                            'item' => function($index, $label, $name, $checked, $value){
                                $return = '<label class="w160 left">';
                                $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" class="access" '.(($value == '1')?" checked":"").'>';
                                $return .= '<span class="radio"></span>';
                                $return .= ucwords($label);
                                $return .= '</label>';

                                return $return;
                            }
                    ])->label(false); ?>
                    <div class="clear"></div>

                </td>
            </tr>
            <?}else{?>
                <?= $form->field($model, 'access')->hiddenInput(['value' => \Yii::$app->user->can('addUpAdmin')? '2':'1'])?>
            <?}?>
            <tr>
                <td class="w180 cl480"></td>
                <td class="settings_user cl480">
                    <p>Выберите доступные для пользователя функции</p>
                    <div class="user_functions">
                        <? $template = "{beginLabel}{input}<span class=\"checkbox\"></span> {labelTitle}{endLabel}"?>
						<?
						$permissions = Yii::$app->authManager->getPermissions();
						foreach ($permissions as $perm) $PermSort[$perm->createdAt] = $perm;
						ksort($PermSort);
						foreach($PermSort as $name => $permission):
							$disabled = ($permission->name == 'addUpUser' || $permission->name == 'addUpAdmin')?:false;
							if(!$permission->ruleName){
								echo $form->field($model, 'rule['.$permission->name.']', [
									'template' => $template
									])->checkbox([
										'value' => '1',
										'disabled' => $disabled,
										], false)->label($permission->description);
							}
						endforeach;?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w180 cl480"></td>
                <td class="settings_user cl480">
					<?=Html::a('Отменить', ['set/users'], ['class' => 'btn cancel'])?>
                    <?= Html::submitInput('Сохранить', ['class' => 'btn']) ?>
                </td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>