<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . '123';
\yii\web\YiiAsset::register($this);
?>
<main>
    <div class="wrap1">
        <div class="about"><h1><?=$client->name?></h1><span class="manager color_grey"><?=$client->user0->surnameNP?></span></div>
        <? if($client->organizations){?>
        <div class="firms">
            <?$orgs = $client->organizations;?>
            <?foreach($orgs as $org){?>
                <div class="firm"><?= Html::a($org->name, ['update', 'id' => $client->id]) ?> <span class="nds color_grey <?=(!$org->nds)?'nds_none':''?>"><?=$org->getAttributeLabel('nds')?></span></div>
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
            <div class="agreed_none">Скидка: <?=$client->discomment?> <?=$client->discount.'%'?></div>
            <a href="" class="agreed">Согласовать</a>
        </div>
        <?}?>
        <p>Доставка: <?=$client->address?></p>
    </div>

    <div class="contacts">
        <div class="wrap1 contact">
            <div>Алексей Васильевич Баландин</div>
            <div class="color_grey">Менеджер по закупкам</div>
            <div class="contact_item"><a href="tel:8-903-647-22-92">8-903-647-22-92</a></div>
            <div class="contact_item"><a href="mailto:meridian331@gmail.com">meridian331@gmail.com</a></div>
        </div>
        <div class="wrap1 contact">
            <div>Барышникова Инна Михайловна</div>
            <div class="color_grey">Бухгалтер</div>
            <div class="contact_item"><a href="tel:8-905-459-15-48">8-905-459-15-48</a></div>
            <div class="contact_item"><a href="mailto:meridian331@gmail.com">meridian332@gmail.com</a></div>
        </div>
        <div class="wrap1 contact">
            <div>Кашичкин Сергей Иванович</div>
            <div class="color_grey">Директор</div>
            <div class="contact_item"><a href="tel:8-905-459-15-31">8-905-459-15-31</a></div>
            <div class="contact_item"><a href="tel:8(4922)54-03-62">8(4922) 54-03-62</a> доб.112</div>
            <div class="contact_item"><a href="mailto:director@meridian-opt.ru">director@meridian-opt.ru</a></div>
        </div>
        <div class="wrap1">
            <div class="contact_site wrap3"><a href="http://meridian-opt.ru">meridian-opt.ru</a></div>
            <div ID="contact-all" class="color_blue">Общие контакты клиента
                <div class="dropdown"></div>
            </div>
            <div class="contact_all">
                <div class="contact_item"><a href="tel:8(4922)54-03-62">8(4922) 54-03-62</a> доб.112</div>
                <div class="contact_item"><a href="tel:8(4922)54-03-62">8(4922) 54-03-62</a> доб.112</div>
                <div class="contact_item"><a href="tel:8(4922)54-03-62">8(4922) 54-03-62</a> доб.112</div>
            </div>

            <div class="contact_all">
                <div class="contact_item"><a href="mailto:director@meridian-opt.ru">director@meridian-opt.ru</a></div>
                <div class="contact_item"><a href="mailto:director@meridian-opt.ru">director@meridian-opt.ru</a></div>
                <div class="contact_item"><a href="mailto:director@meridian-opt.ru">director@meridian-opt.ru</a></div>
            </div>
        </div>
    </div>

    <div class="wrap1">
        <h2>Дела</h2>
        <div class="task">
            <form action="/" method="POST" onsubmit="send(this)">
                <input type="text" class="wrap3" name="task" placeholder="Наименование дела" required>
                <textarea ID="task-comment" name="comment" class="wrap3" placeholder="Комментарий к делу"></textarea>
                <input type="text" name="date-from" class="task_date color_blue" readonly onClick="xCal(this)" readonly onKeyUp="xCal()">
                <div class="task_desc color_blue">Описание дела<div class="dropdown"></div></div>
                <div class="task_time">в
                    <select class="color_blue" name="time">
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                    </select>
                </div>
                <div class="task_time">До
                    <input type="text" name="date-to" class="task_date__s color_blue" readonly onClick="par={class:'xcalend', to:''};xCal(this)" onKeyUp="xCal()">
                </div>
                <input type="submit" class="btn right" value="Добавить">
            </form>
            <div class="clear"></div>
            <div class="task_item">
                <table>
                    <tr class="table_item">
                        <td>
                            <form action="/" method="POST" onsubmit="send(this)">
                                <input type="checkbox" name="task" value="1">
                                <button class="checkbox" title="Закрыть дело"></button>
                            </form>
                        </td>
                        <td class="date">10.07.19</td>
                        <td class="open_desc color_blue">Позвонить Алексею в 15:00 насчёт доставки</td>
                    </tr>
                    <tr class="table_item table_item_hidden">
                        <td></td>
                        <td class="date">в 12:00</td>
                        <td>Планируется доставка муфт на 52 т.р. и хомуты на 43 т.р. в августе по новому адресу</td>
                    </tr>
                </table>
            </div>

            <div class="task_item">
                <table>
                    <tr class="table_item">
                        <td>
                            <form action="/" method="POST" onsubmit="send(this)">
                                <input type="checkbox" name="task" value="2">
                                <button class="checkbox" title="Закрыть дело"></button>
                            </form>
                        </td>
                        <td class="date">15.08.19</td>
                        <td>Проверить доставку</td>
                    </tr>
                </table>
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