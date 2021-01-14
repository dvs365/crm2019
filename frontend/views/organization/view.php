<?php
use yii\helpers\Html;
use frontend\assets\OrganizationAsset;

$this->title = $firm->name;
OrganizationAsset::register($this);
?>
<main>
	<div class="wrap1">
		<?= Html::tag('h1', Html::encode($firm->name))?>
	</div>
	<div class="wrap1 control">
	<?$backLink = (strpos(Yii::$app->request->referrer, 'update') === false)? Yii::$app->request->referrer : ['client/index'];
		$ref = Yii::$app->request->get('ref')?:$backLink;
		$ref2 = Yii::$app->request->get('ref2c')?:Yii::$app->request->get('ref2');
		?>
	<?= Html::a('', $ref.'?ref2c='.urlencode($ref2), ['class' => 'arrow_left']) ?>
	<span class="color_blue" id="open-firm-change">Изменить</span>
	</div>

	<div class="wrap4 client_add">
		<div class="firm_item">
			<table class="w100p">
				<tr>
					<td>
						<?=$firm->getAttributeLabel('form')?>
					</td>
					<td>    
						<?=Html::encode($firm->formLabel)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('name')?>
					</td>
					<td>
						<?=Html::encode($firm->name)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('jadds')?>
					</td>
					<td>
						<?=Html::encode($firm->jadds)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('fadds')?>
					</td>
					<td>
						<?=Html::encode($firm->fadds)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('director')?>
					</td>
					<td>
						<?=Html::encode($firm->director)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('nds')?>
					</td>
					<td>
						<?=Html::encode($firm->ndsLabel)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('phone')?>
					</td>
					<td>
						<?= Html::a(Html::encode($firm->phone), 'tel:'.Html::encode($firm->phone))?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('mail')?>
					</td>
					<td>
						<?= Html::a(Html::encode($firm->mail), 'mailto:'.Html::encode($firm->mail))?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('inn')?>
					</td>
					<td>
						<?= Html::encode($firm->inn)?>
					</td>
				</tr>
				<tr>
					<td class="ogrn">
						<?=$firm->getAttributeLabel('ogrn').(($firm->form = common\models\Organization::FORM_IP)? 'ИП':'')?>
					</td>
					<td>
						<?= Html::encode($firm->ogrn)?>
					</td>
				</tr>
				<?php if ($firm->form != common\models\Organization::FORM_IP):?>
				<tr class="kpp">
					<td>
						<?=$firm->getAttributeLabel('kpp')?>
					</td>
					<td>
						<?= Html::encode($firm->kpp)?>
					</td>
				</tr>
				<?endif;?>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('payment')?>
					</td>
					<td>
						<?= Html::encode($firm->payment)?>
					</td>
				</tr>
				<tr>
					<td>
						<?=$firm->getAttributeLabel('bank')?>
					</td>
					<td>
						<?= Html::encode($firm->bank)?>
					</td>
				</tr>
			</table>
		</div>
		<?=$this->render('update', [
			'firm' => $firm,
			'ref' => $ref,
			'ref2' => Yii::$app->request->get('ref2'),
		])?>
	</div>
</main>