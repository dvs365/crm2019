<main>
    <div class="wrap2 control">
        <a href="clients.html">Потенциальные</a><a href="clients.html">Рабочие</a><a href="clients.html">Отказные</a>
        <a href="clients-add.html" class="btn w160 right">Добавить клиента</a>
        <div class="clear"></div>
    </div>
    <h1 class="wrap1">Передача клиентов</h1>

    <form class="filters wrap1" action="/asd.php" method="GET" onsubmit="send(this)">
        <div class="wrap1 client_transfer_filters">
            <label class="wrap_quarter_manager">Менеджер:
                <div class="select">
                    <div class="dropdown"></div>
                    <select name="manager">
                        <option value="" selected>Все</option>
                        <option value="1">Кириллов Н.Н.</option>
                        <option value="2">Кириллов Н.Н.</option>
                        <option value="3">Кириллов Н.Н.</option>
                        <option value="0">Свободные</option>
                    </select>
                </div>
            </label>

            <label class="wrap_quarter lh30">
                <input type="checkbox" name="potential" value="1">
                <span class="checkbox"></span>
                Потенциальные
            </label>

            <label class="wrap_quarter lh30">
                <input type="checkbox" name="working" value="1">
                <span class="checkbox"></span>
                Рабочие
            </label>

            <label class="wrap_quarter lh30">
                <input type="checkbox" name="refusal" value="1">
                <span class="checkbox"></span>
                Отказные
            </label>
            <div class="clear"></div>
        </div>
        <input type="text" id="search" name="search" placeholder="Разделяйте варианты вертикальным слешем. Например, Иванов | 45-78-62">
        <input type="submit" value="Найти" class="btn w160 right">
        <div id="slash" class="btn w30 right">|</div>
        <div class="clear"></div>
    </form>

    <form class="wrap1" action="/asd.php" method="post" onsubmit="send(this)">
        <table class="clients_table wrap1">
            <tr>
                <td class="w50">
                    <label>
                        <input type="checkbox" name="select-all">
                        <span class="checkbox" title="Выбрать все"></span>
                    </label>
                </td>
                <td><p>Выбрать все</p></td>
            </tr>
        </table>
        <div class="clear"></div>

        <table ID="elements" class="clients_table">
            <tr>
                <td class="w50 lh30">
                    <label>
                        <input type="checkbox" name="client1" value="1">
                        <span class="checkbox"></span>
                    </label>
                </td>
                <td>
                    <div class="wrap4">
                        <div class="about"><a href="client.html" class="about_client">Меридиан</a><span class="manager color_grey">Кириллов Н.Н.</span><span class="about_status color_grey">Рабочий клиент</span></div>
                        <div class="firms">
                            <div class="firm">ИП Мартусевич</div>
                            <div class="firm">Аквастрой</div>
                        </div>
                        <div class="wrap1">
                            <p>Открытие: 1 месяц 22 дня назад</p>
                        </div>
                        <div class="wrap1">
                            <div class="wrap3"><span class="agreed_none">Скидка: на хомуты, на муфты 20%</span> <a href="" class="agreed">Согласовать</a></div>
                            <p class="wrap3">Доставка: Владимир, Ново-Ямская, 81</p>
                            <p><a href="http://meridian-opt.ru" target="_blank">meridian-opt.ru</a></p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w50 lh30">
                    <label>
                        <input type="checkbox" name="client2" value="1">
                        <span class="checkbox"></span>
                    </label>
                </td>
                <td>
                    <div class="wrap4">
                        <div class="about"><a href="client.html" class="about_client">Меридиан</a><span class="about_status color_grey">Рабочий клиент</span></div>
                        <div class="firms">
                            <div class="firm">ИП Мартусевич</div>
                            <div class="firm">Аквастрой</div>
                        </div>
                        <div class="wrap1">
                            <p>Открытие: 1 месяц 22 дня назад</p>
                        </div>
                        <div class="wrap1">
                            <div class="wrap3"><span class="agreed_none">Скидка: на хомуты, на муфты 20%</span> <a href="" class="agreed">Согласовать</a></div>
                            <p class="wrap3">Доставка: Владимир, Ново-Ямская, 81</p>
                            <p><a href="http://meridian-opt.ru" target="_blank">meridian-opt.ru</a></p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w50 lh30">
                    <label>
                        <input type="checkbox" name="client3" value="1">
                        <span class="checkbox"></span>
                    </label>
                </td>
                <td>
                    <div class="wrap4">
                        <div class="about"><a href="client.html" class="about_client">СанТехАрматура (Долгопрудный)</a><span class="about_status color_grey">Отказной клиент</span></div>
                        <div class="firms">
                            <div class="firm">ИП Головчанская Л.С.</div>
                            <div class="firm">ООО "Саноптторг"</div>
                        </div>
                        <div class="wrap1">
                            <p>Открытие: 1 месяц 22 дня назад</p>
                            <p>Причина отказа: компания закрылась</p>
                        </div>
                        <div class="wrap1">
                            <div class="wrap3"><span class="agreed_none">Скидка: 15%</span> <a href="" class="agreed">Согласовать</a></div>
                            <p class="wrap3">Доставка: Московская обл., г.Долгопрудный, Лихачевский пр-т, строение 4</p>
                            <p><a href="http://virsan.ru" target="_blank">virsan.ru</a></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="clients_transfer">
            <tr><td></td><td></td><td></td></tr>
            <tr>
                <td colspan="2">Передать <span class="none360">выбранных клиентов</span> менеджеру</td>
                <td class="wrap_select">
                    <label>

                        <div class="select w200">
                            <div class="dropdown"></div>
                            <select name="manager" class="w200">
                                <option value="1">Кириллов Н.Н.</option>
                                <option value="2">Петрова О.И.</option>
                                <option value="3">Перепелов О.О.</option>
                                <option value="4">Иванов Н.Н.</option>
                                <option value="5">Сидоров О.О.</option>
                            </select>
                        </div>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="lh30">Причина передачи</td>
                <td colspan="2">
                    <textarea name="cause"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" class="btn right" value="Передать">
                </td>
            </tr>
        </table>
    </form>


    <div ID="up" class="right"><a href="#header">Наверх<div class="arrow_up"></div></a></div>
    <div class="clear wrap1"></div>

</main>