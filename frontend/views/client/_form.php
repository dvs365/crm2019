<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<main>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' =>  ['class' => 'client_add wrap4']]); ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="w100p">
            <tr>
                <td class="w180">
                    Клиент
                </td>
                <td>
                    <?= $form->field($model, 'name', ['template' => "{input}"])->textInput(['maxlength' => true]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Статус клиента
                </td>
                <td>
                    <!--<div class="wrap_radio">
                        <label class="wrap_third">
                            <input type="radio" name="status" value="1" checked>
                            <span class="radio"></span>
                            Потенциальный
                        </label>
                        <label class="wrap_third">
                            <input type="radio" name="status" value="2">
                            <span class="radio"></span>
                            Рабочий
                        </label>
                        <label>
                            <input type="radio" name="status" value="3">
                            <span class="radio"></span>
                            Отказной
                        </label>
                        <div class="clear"></div>
                    </div>-->
                    <?= $form->field($model, 'status', ['template' => "{input}"])->radioList(['1' => ' Потенциальный', '2' => ' Рабочий', '3' => 'Отказной'],[
                        'item' => function($index, $label, $name, $checked, $value){
                            $return = '<label class="wrap_third">';
                            $return .= '<input type="radio" name="'.$name.'" value="'.$value.'"  '.(($value == '1')?" checked":"").'>';
                            $return .= '<span class="radio"></span>';
                            $return .= ucwords($label);
                            $return .= '</label>';

                            return $return;
                        },
                        'class' => 'wrap_radio'
                    ])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Скидка
                </td>
                <td>
                    <input type="number" class="discount" min="0" max="99" name="discount"> %
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input type="text" name="discount-comment" placeholder="Комментарий к скидке">
                </td>
            </tr>
            <tr>
                <td>
                    Адрес доставки
                </td>
                <td>
                    <input type="text" name="discount-comment" placeholder="Индекс, страна, регион, город, улица, дом">
                </td>
            </tr>
        </table>
        <h2>Контакты общие</h2>
        <table class="w100p">
            <tr>
                <td class="w180">
                    Телефон
                </td>
                <td>
                    <input type="hidden" name="contact_number" value="1">
                    <input type="hidden" name="id" value="1">
                    <input type="text" class="phone_number" name="phone[1]" placeholder="+7">
                    <input type="text" class="phone_comment" name="phone_comment[1]" placeholder="Комментарий к телефону">
                    <div class="btn right contact_add">Добавить</div>
                </td>
            </tr>
            <tr>
                <td>
                    E-mail
                </td>
                <td>
                    <input type="hidden" name="contact_number" value="1">
                    <input type="hidden" name="id" value="2">
                    <input type="text" class="mail" name="mail[1]" >
                    <div class="btn right contact_add">Добавить</div>
                </td>
            </tr>
        </table>
        <div class="client_item">
            <h2>Контактное лицо <span class="client_item_number">1</span></h2>
            <table class="w100p">
                <tr>
                    <td class="w180">
                        ФИО
                    </td>
                    <td>
                        <input type="text" name="person-FIO[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        Должность
                    </td>
                    <td>
                        <input type="text" name="person-position[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        Телефон
                    </td>
                    <td>
                        <input type="hidden" name="contact_number" value="1">
                        <input type="hidden" name="id" value="3">
                        <input type="text" class="phone_number" name="person-phone[1][1]" placeholder="+7">
                        <input type="text" class="phone_comment" name="person-phone-comment[1][1]" placeholder="Комментарий к телефону">
                        <div class="btn right contact_add">Добавить</div>
                        <div class="clear"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail
                    </td>
                    <td>
                        <input type="hidden" name="contact_number" value="1">
                        <input type="hidden" name="id" value="4">
                        <input type="text" class="mail" name="person-mail[1][1]" >
                        <div class="btn right contact_add">Добавить</div>
                        <div class="clear"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="color_blue client_item_add">Добавить контактное лицо <div class="dropdown"></div></div>
        <div class="f17">Организации клиента</div>
        <div class="client_item">
            <h2>Организация <span class="client_item_number">1</span></h2>
            <table class="w100p">
                <tr>
                    <td class="w180 lh">
                        Форма собственности
                    </td>
                    <td>
                        <div class="wrap_select">
                            <label class="select_property">
                                <div class="select">
                                    <div class="dropdown"></div>

                                    <select name="firm-ownership[1]">
                                        <option value="1" selected>ООО</option>
                                        <option value="2">АО</option>
                                        <option value="3">ПАО</option>
                                        <option value="4">МУП</option>
                                        <option value="5">ФГУП</option>
                                        <option value="6">ИП</option>
                                    </select>
                                </div>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Наименование
                    </td>
                    <td>
                        <input type="text" name="firm-name[1]" >
                    </td>
                </tr>
                <tr>
                    <td class="lh">
                        Юридический адрес
                    </td>
                    <td>
                        <input type="text" name="firm-legal-adres[1]" placeholder="Индекс, страна, регион, улица, дом">
                    </td>
                </tr>
                <tr>
                    <td class="lh">
                        Фактический адрес
                    </td>
                    <td>
                        <input type="text" name="firm-fact-adres[1]" placeholder="Индекс, страна, регион, улица, дом">
                    </td>
                </tr>
                <tr>
                    <td>
                        ФИО директора
                    </td>
                    <td>
                        <input type="text" name="firm-director[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        НДС
                    </td>
                    <td>
                        <div class="wrap_radio">
                            <label class="wrap_third">
                                <input type="radio" name="NDS[1]" value="1">
                                <span class="radio"></span>
                                С НДС
                            </label>
                            <label>
                                <input type="radio" name="NDS[1]" value="2">
                                <span class="radio"></span>
                                Без НДС
                            </label>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Телефон
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-phone[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-mail[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        ИНН
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-INN[1]" >
                    </td>
                </tr>
                <tr>
                    <td class="ogrn">
                        ОГРН
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-OGRN[1]" >
                    </td>
                </tr>
                <tr class="kpp">
                    <td>
                        КПП
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-KPP[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        Расчётный счёт
                    </td>
                    <td>
                        <input type="text" class="firm_detail" name="firm-account[1]" >
                    </td>
                </tr>
                <tr>
                    <td>
                        Банк
                    </td>
                    <td>
                        <input type="text" name="firm-bank[1]" >
                    </td>
                </tr>
            </table>
        </div>
        <div class="color_blue client_item_add">Добавить организацию <div class="dropdown"></div></div>
        <div class="wrap_select left">
            <label>Менеджер:
                <div class="select">
                    <div class="dropdown"></div>

                    <select name="manager">
                        <option value="1">Кириллов Н.Н.</option>
                        <option value="2">Кириллов Н.Н.</option>
                        <option value="3">Кириллов Н.Н.</option>
                    </select>
                </div>
            </label>
        </div>
        <div class="right">
            <a href="clients.html" class="btn cancel">Отменить</a>
            <input type="submit" class="btn" value="Сохранить">
        </div>
        <div class="clear"></div>
    <?php ActiveForm::end(); ?>


</main>