<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_client_org', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items_client_org', // required: css class selector
    'widgetItem' => '.client_org_item', // required: css class
    'limit' => 10, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.item-add_client_org', // css class
    'deleteButton' => '.remove-item_client_mail', // css class
    'model' => $modelsOrganization[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'name',
		'valid',
        'form',
        'jadds',
        'fadds',
        'director',
        'nds',
        'phone',
        'mail',
        'inn',
        'ogrn',
        'kpp',
        'payment',
        'bank'
    ],
]); ?>
<div class="container-items_client_org">
    <?php foreach($modelsOrganization as $indexOrg => $clientOrg):?>
    <div class="client_org_item">

    <!--<h2>Организация <span class="client_item_number" id="organization<?=$clientOrg->id?>"><?=$indexOrg+1?></span></h2>-->
        <?php
        //necessary for update action.
        if(!$clientOrg->isNewRecord) {
            echo Html::activeHiddenInput($clientOrg, "[{$indexOrg}]id");
        }
        ?>
        <table class="w100p">
			<tr>
				<td>
					<h2>Организация <span class="client_item_number" id="organization<?=$clientOrg->id?>"><?=$indexOrg+1?></span></h2>
				</td>
				<td>
					<span class="client_item_main"><label>
						<?=$form->field($clientOrg, "[{$indexOrg}]valid", ['template' => "{input}<span class=\"checkbox\"></span> ".$clientOrg->getAttributeLabel('valid')])->checkbox([], false)?>
					</label></span>
				</td>
			</tr>		
            <tr>
                <td class="w180 lh">
                    Форма собственности
                </td>
                <td>
                    <div class="wrap_select">
                        <label class="select_property">
                            <div class="select">
                                <div class="dropdown"></div>
                                <?=$form->field($clientOrg, "[{$indexOrg}]form", ['template' => "{input}"])->dropDownList($clientOrg->formLabels);?>
                            </div>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('name')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]name", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td class="lh">
                    <?=$clientOrg->getAttributeLabel('jadds')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]jadds", ['template' => "{input}"])->textInput(['maxlength' => true, 'placeholder' => 'Индекс, страна, регион, улица, дом']) ?>
                </td>
            </tr>
            <tr>
                <td class="lh">
                    <?=$clientOrg->getAttributeLabel('fadds')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]fadds", ['template' => "{input}"])->textInput(['maxlength' => true, 'placeholder' => 'Индекс, страна, регион, улица, дом']) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('director')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]director", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('nds')?>
                </td>
                <td>
                    <div class="wrap_radio">
                    <? $clientOrg->isNewrecord?$clientOrg->nds = common\models\Organization::UNKNOWNNDS:''?>
                    <?= $form->field($clientOrg, "[{$indexOrg}]nds", ['template' => "{input}"])->radioList($clientOrg->getNdsLabels(),[
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
                    <?=$clientOrg->getAttributeLabel('phone')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]phone", ['template' => "{error}{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('mail')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]mail", ['template' => "{error}{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('inn')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]inn", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <tr>
                <td class="ogrn">
                    <?=$clientOrg->getAttributeLabel('ogrn').(($clientOrg->form = common\models\Organization::FORM_IP)? 'ИП':'')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]ogrn", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <?php if ($clientOrg->form != common\models\Organization::FORM_IP):?>
            <tr class="kpp">
                <td>
                    <?=$clientOrg->getAttributeLabel('kpp')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]kpp", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <?endif;?>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('payment')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]payment", ['template' => "{input}"])->textInput(['maxlength' => true, 'class' => 'firm_detail']) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$clientOrg->getAttributeLabel('bank')?>
                </td>
                <td>
                    <?= $form->field($clientOrg, "[{$indexOrg}]bank", ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
        </table>
    </div>
    <?php endforeach;?>
</div>
<div class="color_blue client_item_add item-add_client_org">Добавить организацию <div class="dropdown"></div></div>
<?php DynamicFormWidget::end(); ?>