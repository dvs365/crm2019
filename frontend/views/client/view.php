<?php
use yii\helpers\Html;
use frontend\assets\ClientAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);
?>
<main>
	<div class="wrap4">
		<div class="wrap4 control">
			<?$backLink = (strpos(Yii::$app->request->referrer, 'update') === false && 
				strpos(Yii::$app->request->referrer, 'create') === false)? Yii::$app->request->referrer : ['client/index'];
				$ref = (Yii::$app->request->get('ref')?: $backLink);
				?>
			<?= Html::a('', Yii::$app->request->get('ref')?:$backLink, ['class' => 'arrow_left']) ?>
			<?= Html::a('Изменить', ['update', 'id' => $client->id, 'ref' => $ref]) ?>
			<?= ($client->status !== common\models\Client::TARGET)?Html::a('В потенциальные', ['totarget', 'id' => $client->id, 'ref' => $ref]):''?>
			<?= ($client->status !== common\models\Client::LOAD)?Html::a('В рабочие', ['toload', 'id' => $client->id, 'ref' => $ref]):''?>
			<?= ($client->status !== common\models\Client::REJECT)?Html::a('В отказные', ['toreject', 'id' => $client->id, 'ref' => $ref], ['id' => 'refusal']):''?>
			<div id="refusal-case" class="w900">
				<? $form = ActiveForm::begin(['action' => ['client/toreject', 'id' => $client->id, 'ref' => $ref], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
				<?=$form->field($desclient, 'reject', ['template' => "{input}"])->textArea(['placeholder' => 'Причина отказа', 'class' => 'autoheight', 'maxlength' => true]) ?>
				<?= Html::tag('div', Html::tag('pre',''), ['class' => 'fake_textarea'])?>
				<?= Html::submitInput('Отправить', ['class' => 'addtodo btn right'])?>
				<?= Html::tag('div', '', ['class' => 'clear'])?>
				<? ActiveForm::end(); ?>
			</div>
		</div>
	
		<div class="wrap4">
			<div class="wrap4">
				<div class="about"><h1><?=$client->name?></h1><span class="manager color_grey"><?=$client->user0->surnameNP?></span></div>
				<?if($client->organizations):?>
					<ul class="firms wrap3">
						<?$orgs = $client->organizations;?>
						<?foreach($orgs as $org){?>
							<li class="firm">
								<?= Html::a($org->formLabel.' '.$org->name, ['client/update', 'id' => $client->id, '#' => 'organization'.$org->id]) ?>
								<span class="nds color_grey <?=($org->nds == $org->ndsConst['without'])?'nds_none':''?>"><?=$org->nds ? $org->getAttributeLabel('nds'):''?></span>
							</li>
						<?}?>
					</ul>
				<?endif;?>
				<?if($client->comment):?>
					<?$commentDiv = Html::tag('div', Html::encode($client->comment), ['class' => 'client_comment']);?>
					<?=Html::tag('div', $commentDiv, ['class' => 'wrap1'])?>
				<?endif;?>
			</div>
			
			<div class="wrap1">
				<table class="client_discount">
					<tr>
						<th>Скидка:</th>
						<td>
							<span <?=($client->disconfirm)?'':'class="agreed_none"'?>><?=($client->discount)?$client->discount.'%':''?></span>
							<?if(\Yii::$app->user->can('confirmDiscount') && !$client->disconfirm && ($client->discomment || $client->discount)):?>
								<?=Html::a('Согласовать', ['disconfirm', 'id' => $client->id], ['class' => 'agreed'])?>
							<?endif;?>
							<br><span <?=($client->disconfirm)?'':'class="agreed_none"'?>><?=($client->discomment)?$client->discomment:''?></span>
						</td>
					</tr>
				</table>			
			</div>
			<div class="wrap1">
				<table class="clients_list_delivery">
					<tr>
						<td>Доставка:</td>
						<td>
							<ul>
								<li><?=$client->address?></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>			
		</div>
		<div class="contacts">
			<?php foreach($clientFaces as $clientFace):?>
			<div class="wrap1 contact">
				<?$mainFaceClass = $clientFace->main ? ' contact_main' : ''?>
				<?= Html::tag('div', Html::encode($clientFace->fullname), ['class' => 'f1125'.$mainFaceClass])?>
				<?= Html::tag('div', Html::encode($clientFace->position), ['class' => 'color_grey'])?>
				<?$fphones = $clientFace->phonefaces; $fmails = $clientFace->mailfaces;?>
				<?php foreach($fphones as $fphone):?>
					<div class="contact_item"><a href="tel:<?=$fphone->number?>"><?=$fphone->number?></a><?=' '.$fphone->comment?></div>
				<?php endforeach;?>
				<?php foreach($fmails as $fmail):?>
					<div class="contact_item"><a href="mailto:<?=$fmail->mail?>"><?=$fmail->mail?></a></div>
				<?php endforeach;?>
			</div>
			<?php endforeach;?>
			<div class="wrap1">
				<?$cphones = $client->phoneclients; $cmails = $client->mailclients;?>
				<div class="contact_site wrap1">
					<?$webArr = explode(',', $client->website);?>
						<?foreach ($webArr as $web):?>
							<?=Html::a(Html::encode($web), Html::encode($web), ['target' => '_blank']);?>
						<?endforeach;?>
				</div>
				<div ID="contact-all" class="wrap3 color_blue">Общие контакты клиента
					<div class="dropdown"></div>
				</div>
				<div class="wrap3 contact_all">
					<?php foreach($cphones as $cphone):?>
						<div class="contact_item">
							<a href="tel:<?=$cphone->number?>"><?=$cphone->number?></a><?=' '.$cphone->comment?>
						</div>
					<?php endforeach;?>
				</div>

				<div class="contact_all">
					<?php foreach($cmails as $cmail):?>
						<div class="contact_item">
							<a href="mailto:<?=Html::encode($cmail->mail)?>"><?=Html::encode($cmail->mail)?></a>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>


    <div class="wrap4">
        <h2>Дела</h2>
        <div class="task wrap_client_task">
            <?= $this->render('_form_todo', [
                'client' => $client,
				'todo' => new common\models\Todo,
            ]) ?>
            <div class="clear"></div>
            <div id="outputtodo">
            <?=$this->render('_form_list_todo', [
                'todos' => $client->todosOpen,
            ]);?>
            </div>
        </div>
    </div>

    <div class="wrap4">
        <h2>Комментарии</h2>
        <div class="comments" id="comments">
            <?= $this->render('_form_comment', [
                'client' => $client,
            ]) ?>
            <div class="wrap3">
                <table id="commentsTable">
                    <?=$this->render('_form_list_comment', [
                        'comments' => $client->comments,
                    ]);?>
                </table>
            </div>
            <a href="<?=Url::toRoute(['comment/view', 'id' => $client->id])?>" ID="comment-open10" class="comment_open color_blue">Ещё 10 комментариев<div class="dropdown"></div></a>
            <a href="" ID="comment-openall" class="comment_open color_blue">Все комментарии<div class="dropdown"></div></a>
            <div class="clear"></div>
        </div>
    </div>
    <?if(\Yii::$app->user->can('admin')):?>
		<div class="wrap4">
			<h2>Открытия</h2>
			<table>
				<tr class="table_item">
					<td class="date color_grey"><?=\Yii::$app->formatter->asDate($client->show_u, "php:d.m.y в H:i")?></td>
					<td><?=$show_uid->surnameNP?></td>
				</tr>
				<tr class="table_item">
					<td class="date color_grey"><?=\Yii::$app->formatter->asDate($client->show_a, "php:d.m.y в H:i")?></td>
					<td><?=$show_aid->surnameNP?></td>
				</tr>
			</table>
		</div>

		<div class="wrap4">
			<h2>Операции</h2>
			<table>
				<tr class="table_item">
					<td class="date color_grey"><?=\Yii::$app->formatter->asDate($client->created, "php:d.m.y в H:i")?></td>
					<td>Добавление - <?=($client->created_id)?\common\models\User::findOne($client->created_id)->surnameNP:'-'?></td>
				</tr>
				<tr class="table_item">
					<td class="date color_grey"><?=\Yii::$app->formatter->asDate($client->update_u, "php:d.m.y в H:i")?></td>
					<td>Изменение - <?=($client->update_uid)?\common\models\User::findOne($client->update_uid)->surnameNP:'-'?></td>
				</tr>
			</table>
		</div>
		<?if(\Yii::$app->user->can('addNoteClient')):?>
			<div class="wrap4">
				<h2>Заметка</h2>
				<div id="note-open" class="color_blue wrap3"><?=$client->note?:'Создать'?></div>
				<?=$this->render('_form_note', [
					'client' => $client,
				]);?>
			</div>
		<?endif;?>
    <?endif;?>
</main>