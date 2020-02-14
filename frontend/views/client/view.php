<?php
use yii\helpers\Html;
use frontend\assets\ClientAsset;

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
                    <?= Html::a($org->name, ['update', 'id' => $client->id]) ?>
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
        <?= ($client->status !== 30)?Html::a('В отказные', ['toreject', 'id' => $client->id]):''?>
    </div>

    <div class="wrap1">
        <?if($client->discount) {?>
        <div class="wrap3">
            <div <?=($client->disconfirm)?'':'class="agreed_none"'?>>Скидка: <?=$client->discomment?> <?=$client->discount.'%'?></div>
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
            <div class="contact_site wrap3"><a href="//<?=$client->website?>"><?=$client->website?></a></div>
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
        <div class="comments">
            <form action="/" method="POST" onsubmit="send(this)">
                <textarea class="wrap3" name="comment" placeholder="Новый комментарий" required></textarea>
                <input type="submit" class="btn right" value="Добавить">
            </form>
            <div class="comment_date"></div>
            <div class="clear"></div>
            <div class="wrap3">
                <table>
                    <tr class="table_item">
                        <td class="date color_grey this_year">07.06</td>
                        <td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey this_year">25.03</td>
                        <td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey this_year">09.01</td>
                        <td>обн прайс, закажет по потр</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">24.11.18</td>
                        <td>отгр муфт 20% и немного хом 10%  на Аквастрой на 96 тыр</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">12.06.18</td>
                        <td>отгр  муфт скидка 20% и немного хом 10%  на Аквастрой на 108 тыр, муфты под заказ клиента</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">08.07.18</td>
                        <td>клиенты пожаловались, что муфты срывает с трубы на горячем водоснабжении, на холодном нормально почему-то. Хотят вернуть партию как брак, если будут еще подобные случаи</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">05.06.18</td>
                        <td>муфты передумал брать, на образец никто из клиентов не клюнул</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">15.05.18</td>
                        <td>дал намуфты 15%, будет думать</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">14.04.18</td>
                        <td>отгр на Меридиан муфт 20% и немного хом 10% на 29 тыр</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">25.02.18</td>
                        <td>пока ест</td>
                    </tr>
                </table>
            </div>
            <a href="" ID="comment-open10" class="comment_open color_blue">Ещё 10 комментариев<div class="dropdown"></div></a>
            <a href="" ID="comment-openall" class="comment_open color_blue">Все комментарии<div class="dropdown"></div></a>
            <div class="clear"></div>
        </div>
    </div>

    <div class="wrap1">
        <h2>Открытия</h2>
        <table>
            <tr class="table_item">
                <td class="date color_grey">07.06.19 в 15:41</td>
                <td>Кириллов Н.Н.</td>
            </tr>
            <tr class="table_item">
                <td class="date color_grey">25.03.19 в 13:48</td>
                <td>Зайцева Н.В.</td>
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
        </table>
    </div>

    <div class="wrap1">
        <h2>Заметка</h2>
        <div id="note-open" class="color_blue wrap3">Всё отлично</div>
        <form class="note" action="/" method="POST" onsubmit="send(this)">
            <textarea name="note" class="wrap3" placeholder="Заметка" required>Всё отлично</textarea>
            <input type="submit"  class="btn right" value="Добавить">
            <div class="clear"></div>
        </form>
    </div>
</main>