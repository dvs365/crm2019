<?php
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['view', 'id' => $firm->id, 'ref' => $ref, 'ref2' => $ref2], 'options' =>  ['class' => 'firm_item_change']]); ?>
	<table class="w100p">
		<tr>
			<td>
				<?=$firm->getAttributeLabel('form')?>
			</td>
			<td>    
				<div class="wrap_select">
					<label class="select_property">
						<span class="select">
							<span class="dropdown"></span>
							<?=$form->field($firm, "form", ['template' => "{input}"])->dropDownList($firm->formLabels);?>
						</span>
					</label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('name')?>
			</td>
			<td>
				<?=$form->field($firm, "name", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('jadds')?>
			</td>
			<td>
				<?=$form->field($firm, "jadds", ['template' => "{input}"])->textInput(['maxlength' => true, 'placeholder' => 'Индекс, страна, регион, улица, дом']) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('fadds')?>
			</td>
			<td>
				<?=$form->field($firm, "fadds", ['template' => "{input}"])->textInput(['maxlength' => true, 'placeholder' => 'Индекс, страна, регион, улица, дом']) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('director')?>
			</td>
			<td>
				<?=$form->field($firm, "director", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('nds')?>
			</td>
			<td>
				<div class="wrap_radio">
                    <?= $form->field($firm, "nds", ['template' => "{input}"])->radioList($firm->getNdsLabels(),[
                        'item' => function($index, $label, $name, $checked, $value){
                            $return = '<label class="wrap_third">';
                            $return .= '<input type="radio" name="'.$name.'" value="'.$value.'"'.($checked ? ' checked':'').'>';
                            $return .= '<span class="radio"></span>';
                            $return .= ucwords($label);
                            $return .= '</label>';
                            return $return;
                        }
                    ])->label(false); ?>
					<div class="clear"></div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('phone')?>
			</td>
			<td>
				<?= $form->field($firm, "phone", ['template' => "{error}{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('mail')?>
			</td>
			<td>
				<?= $form->field($firm, "mail", ['template' => "{error}{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('inn')?>
			</td>
			<td>
				<?= $form->field($firm, "inn", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<tr>
			<td class="ogrn">
				<?=$firm->getAttributeLabel('ogrn').(($firm->form = common\models\Organization::FORM_IP)? 'ИП':'')?>
			</td>
			<td>
				<?= $form->field($firm, "ogrn", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<?php if ($firm->form != common\models\Organization::FORM_IP):?>
		<tr class="kpp">
			<td>
				<?=$firm->getAttributeLabel('kpp')?>
			</td>
			<td>
				<?= $form->field($firm, "kpp", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('payment')?>
			</td>
			<td>
				<?= $form->field($firm, "payment", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$firm->getAttributeLabel('bank')?>
			</td>
			<td>
				<?=$form->field($firm, "bank", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
			</td>
		</tr>
		<?=$form->field($firm, "client")->hiddenInput()->label(false) ?>
	</table>
	<div class="right">
		<a href="client.html" id="close-firm-change" class="btn cancel" onclick="return false">Отменить</a>
		<input type="submit" class="btn" value="Сохранить">
	</div>
	<div class="clear"></div>
<?php ActiveForm::end(); ?>