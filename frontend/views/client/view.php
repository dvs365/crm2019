<?php
use yii\helpers\Html;
use frontend\assets\ClientAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . '123';
\yii\web\YiiAsset::register($this);
ClientAsset::register($this);
?>
<main>
    <div class="wrap1">
        <div class="about"><h1><?=$client->name?></h1><span class="manager color_grey"><?=$client->user0->surnameNP?></span></div>
        <? if($client->organizations){?>
        <div class="firms">
            <?$orgs = $client->organizations;?>
            <?foreach($orgs as $org){?>
                <div class="firm">
                    <?= Html::a($org->formLabel.' '.$org->name, ['client/update', 'id' => $client->id, '#' => 'organization'.$org->id]) ?>
                    <span class="nds color_grey <?=($org->nds == $org->ndsConst['without'])?'nds_none':''?>"><?=$org->getAttributeLabel('nds')?></span>
                </div>
            <?}?>
        </div>
        <?}?>
    </div>

    <div class="wrap1 control">
        <?= Html::a('', Yii::$app->request->referrer, ['class' => 'arrow_left']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $client->id]) ?>
        <?= ($client->status !== 10)?Html::a('В потенциальные', ['totarget', 'id' => $client->id]):''?>
        <?= ($client->status !== 20)?Html::a('В рабочие', ['toload', 'id' => $client->id]):''?>
        <?= ($client->status !== 30)?Html::a('В отказные', ['toreject', 'id' => $client->id], ['id' => 'toreject']):''?>
        <?php $form = ActiveForm::begin(['id' => 'formrejectlient', 'action' => ['client/toreject', 'id' => $client->id], 'method' => 'post', 'enableAjaxValidation' => false, 'validateOnBlur' => false]); ?>
        <?=$form->field($desclient, 'reject', ['template' => "{input}"])->textArea(['placeholder' => 'Комментарий к делу', 'class' => 'wrap3', 'maxlength' => true]) ?>
        <?=Html::submitInput('Перевести', ['class' => 'addtodo btn right'])?>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="wrap1">
        <?if($client->discount || $client->discomment) {?>
        <div class="wrap3">
            <div <?=($client->disconfirm)?'':'class="agreed_none"'?>>Скидка: <?=$client->discomment?> <?=($client->discount)?$client->discount.'%':''?></div>
            <?if(\Yii::$app->user->can('confirmDiscount') && !$client->disconfirm):?>
                <?=Html::a('Согласовать', ['disconfirm', 'id' => $client->id], ['class' => 'agreed'])?>
            <?endif;?>
        </div>
        <?}?>
        <p>Доставка: <?=$client->address?></p>
    </div>

    <div class="contacts">
        <?php foreach($clientFaces as $clientFace):?>
        <div class="wrap1 contact">
            <div><?=$clientFace->fullname?></div>
            <div class="color_grey"><?=$clientFace->position?></div>
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
            <div class="contact_site wrap3">
                <?$webArr = explode(',', $client->website);?>
                    <?foreach ($webArr as $web):?>
                        <?=Html::a(Html::encode(trim($web)), '//'.Html::encode(trim($web)));?>
                    <?endforeach;?>
            </div>
            <div ID="contact-all" class="color_blue">Общие контакты клиента
                <div class="dropdown"></div>
            </div>
            <div class="contact_all">
                <?php foreach($cphones as $cphone):?>
                    <div class="contact_item"><a href="tel:<?=$cphone->number?>"><?=$cphone->number?></a><?=' '.$cphone->comment?></div>
                <?php endforeach;?>
            </div>

            <div class="contact_all">
                <?php foreach($cmails as $cmail):?>
                <div class="contact_item"><a href="mailto:<?=$cmail->mail?>"><?=$cmail->mail?></a></div>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <div class="wrap1">
        <h2>Дела</h2>
        <div class="task">
            <?= $this->render('_form_todo', [
                'client' => $client,
            ]) ?>
            <div class="clear"></div>
            <div id="outputtodo">
            <?=$this->render('_form_list_todo', [
                'todos' => $client->todos,
            ]);?>
            </div>
        </div>
    </div>

    <div class="wrap1">
        <h2>Комментарии</h2>
        <div class="comments" id="comments">
            <?= $this->render('_form_comment', [
                'client' => $client,
            ]) ?>
            <div class="comment_date"></div>
            <div class="clear"></div>
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
    <div class="wrap1">
        <h2>Открытия</h2>
        <table>
            <tr class="table_item">
                <?$show_u = \DateTime::createFromFormat('Y-m-d H:i:s', $client->show_u)?>
                <td class="date color_grey"><?=$show_u->format('d.m.y в H:i')?></td>
                <td><?=$show_uid->surnameNP?></td>
            </tr>
            <tr class="table_item">
                <?$show_a = \DateTime::createFromFormat('Y-m-d H:i:s', $client->show_a)?>
                <td class="date color_grey"><?=$show_a->format('d.m.y в H:i')?></td>
                <td><?=$show_aid->surnameNP?></td>
            </tr>
        </table>
    </div>

    <div class="wrap1">
        <h2>Операции</h2>
        <table>
            <tr class="table_item">
                <td class="date color_grey">07.06.19</td>
                <td>Добавление - Кириллов Н.Н.</td>
            </tr>
            <tr class="table_item">
                <?$update_u = \DateTime::createFromFormat('Y-m-d H:i:s', $client->update_u)?>
                <td class="date color_grey"><?=$update_u->format('d.m.y в H:i')?></td>
                <td>Изменение - <?=($client->update_uid)?\common\models\User::findOne($client->update_uid)->surnameNP:'-'?></td>
            </tr>
        </table>
    </div>

    <div class="wrap1">
        <h2>Заметка</h2>
        <div id="note-open" class="color_blue wrap3"><?=$client->note?:'Создать'?></div>
        <?=$this->render('_form_note', [
            'client' => $client,
        ]);?>
    </div>
    <?endif;?>
</main>