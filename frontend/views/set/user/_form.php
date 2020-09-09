<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\SettingAsset;
use yii\helpers\ArrayHelper;

\yii\web\YiiAsset::register($this);
SettingAsset::register($this);
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
			<? 
			if (!empty($model->id)) :?>
			<tr>
				<td class="w180 cl360">Статус пользователя</td>
				<td class="settings_user">
                    <?= $form->field($model, 'status', ['template' => "{input}"])->radioList(['10' => ' Активный', '0' => ' Архивный'],[
                            'item' => function($index, $label, $name, $checked, $value){
                                $return = '<label class="w160 left">';
                                $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" class="access" '.($checked?'checked':'').'>';
                                $return .= '<span class="radio"></span>';
                                $return .= ucwords($label);
                                $return .= '</label>';
                                return $return;
                            }
                    ])->label(false); ?>
					<div class="clear wrap3"></div>
					<div ID="status-archive">
						<p>У пользователя <span ID="clients_col"><?=$cntClient?></span> клиента(ов). Выберите для них новых пользователей</p>
						<div ID="distribution" class="wrap_select">
							<label><span class="user">Пользователь:</span>
								<span ID="choise_user" class="select">
									<span class="users_choised"></span>
									<span class="dropdown"></span>
									<span class="choise_user">
										<?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
										<?=$form->field($model, 'users[]', ['template' => "{input}"])->dropDownList($managers, ['class' => '', 'multiple'=>'multiple'])?>									
									</span>
								</span>
							</label>
							<p>Клиенты будут распределены по следующим пользователям: <span class="users_choised"></span></p>
						</div>
					</div>
				</td>
			</tr>
			<? endif;?>
            <tr>
                <td class="w180 cl360">Право доступа</td>
                <td class="settings_user">
                    <?= $form->field($model, 'access', ['template' => "{input}"])->radioList(['1' => ' Базовый', '2' => ' Расширенный'],[
                            'item' => function($index, $label, $name, $checked, $value){
                                $return = '<label class="w160 left">';
                                $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" id="access" '.($checked?'checked':'').'>';
                                $return .= '<span class="radio"></span>';
                                $return .= ucwords($label);
                                $return .= '</label>';
                                return $return;
                            }
                    ])->label(false); ?>
                    <div class="clear"></div>

                </td>
            </tr>
            <tr>
                <td class="w180 cl480"></td>
                <td class="settings_user cl480">
                    <p>Выберите доступные для пользователя функции</p>
                    <div class="user_functions">
						<?
						$spanAddClass = $model->access == 1 ? 'checkbox_disabled' : '';
						$permissions = Yii::$app->authManager->getPermissions();
						foreach ($permissions as $perm) $PermSort[$perm->createdAt] = $perm;
						ksort($PermSort);
						foreach($PermSort as $name => $permission):
							$notbase = ($permission->name == 'addUpUser' || $permission->name == 'addUpAdmin')?'notbase '.(($model->access == 1)?'color_grey':''):false;
							if(!$permission->ruleName){
								echo $form->field($model, 'rule['.$permission->name.']', [
									'template' => "{beginLabel}{input}<span class=\"checkbox ".($notbase ? $spanAddClass : '')."\"></span> {labelTitle}{endLabel}",
									'labelOptions' => ['class' => $notbase],
									])->checkbox([
										'value' => '1',
										'disabled' => ($model->access == 1 && $notbase)? true:false,
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