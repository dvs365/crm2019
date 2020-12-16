<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<main>
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' =>  ['class' => 'client_add']]); ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="w100p wrap3-0">
            <tr>
                <td>
                    <?=$model->getAttributeLabel('name')?>
                </td>
                <td>
                    <?= $form->field($model, 'name', ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
			<tr>
				<td>
					<?=$model->getAttributeLabel('comment')?>
				</td>
				<td>
					<?=$form->field($model, 'comment', ['template' => "{input}"])->textArea(['placeholder' => 'Новый комментарий', 'class' => 'client_add_delivery autoheight', 'maxlength' => true]) ?>
					<?=Html::tag('div', Html::tag('pre'), ['class' => 'fake_textarea'])?>
				</td>
			</tr>
            <tr>
                <td>
                    <?=$model->getAttributeLabel('status')?>
                </td>
                <td>
                    <? $model->isNewrecord?$model->status = common\models\Client::TARGET : $model->status;?>
                    <?= $form->field($model, 'status', ['template' => "{input}<div class=\"clear\"></div>"])->radioList($model->getStatusLabels(),[
                        'item' => function($index, $label, $name, $checked, $value){
                            $return = Html::beginTag('label', ['class' => 'wrap_third']);
                            $return .= '<input type="radio" name="'.$name.'" value="'.$value.'"  '.(($value == $checked)?" checked":"").'>';
                            $return .= '<span class="radio"></span> ';
                            $return .= ucwords($label);
                            $return .= Html::endTag('label') .(($index == '2')?'<div class="clear"></div>' : '');

                            return $return;
                        },
                        'class' => 'wrap_radio'
                    ])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$model->getAttributeLabel('discount')?>
                </td>
                <td>
                    <?= $form->field($model, 'discount', ['template' => "{input} %"])->input('number', ['class' => 'discount']) ?>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <?= $form->field($model, 'discomment', ['template' => "{input}"])->textInput(['placeholder' => 'Комментарий к скидке', 'maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$model->getAttributeLabel('address')?>
                </td>
                <td>
                    <?= $form->field($model, 'address', ['template' => "{input}"])->textInput(['placeholder' => 'Индекс, страна, регион, город, улица, дом', 'maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$model->getAttributeLabel('website')?>
                </td>
                <td>
                    <?= $form->field($model, 'website', ['template' => "{input}"])->textInput(['placeholder' => 'Сайт, сайт', 'maxlength' => true]) ?>
                </td>
            </tr>
        </table>
        <h2>Контакты общие</h2>
        <?=$this->render('_form_client_phone', [
                'form' => $form,
                'modelsClientPhone' => $modelsClientPhone,
                'model' => $model,
        ]);
        ?>
        <?=$this->render('_form_client_mail', [
            'form' => $form,
            'modelsClientMail' => $modelsClientMail,
            'model' => $model,
        ]);
        ?>
        <?=$this->render('_form_client_face', [
            'form' => $form,
            'modelsFace' => $modelsClientFace,
            'modelsFacePhone' => $modelsFacePhone,
            'modelsFaceMail' => $modelsFaceMail,
            'model' => $model,
        ]);
        ?>
        <div class="f17 wrap3-0">Организации клиента</div>
        <?=$this->render('_form_client_organization', [
            'form' => $form,
            'modelsOrganization' => $modelsOrganization,
            'model' => $model,
        ]);
        ?>
        <div class="fixed_footer">
			<div class="w900">
				<div class="wrap_select left">
					<?if(\Yii::$app->user->can('admin')):?>
						<?$user = Yii::$app->user->identity; $managerIDs = array_merge(explode(',', $user->managers), [$user->id])?>
						<?$users =  \common\models\User::find()->where(['id' => $managerIDs])->all()?>
					<label>Менеджер:<?$model->user = (!empty($model->user)) ? $model->user : $user->id?>
						<span class="select">
							<span class="dropdown"></span>
							<?$managers = ArrayHelper::map($users, 'id', 'surnameNP')?>
							<?=$form->field($model, 'user', ['template' => "{input}"])->dropDownList($managers, ['class' => '', 'options' => [$model->user => ['selected' => true]]])?>
						</span>
					</label>
					<?endif;?>
				</div>
				<div class="right">
					<?=Html::a('Отменить', ['client/view', 'id' => $model->id, 'ref' => Yii::$app->request->get('ref')], ['class' => 'btn cancel'])?>
					<?=Html::submitInput('Сохранить', ['class' => 'btn'])?>
				</div>
				<div class="clear"></div>					
			</div>
		</div>

    <?php ActiveForm::end(); ?>


</main>