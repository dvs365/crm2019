        <main>
            <div class="wrap1 control">
                <?=$this->render('_menu')?>
            </div>
            <div id="open-add-work" class="color_blue f128 wrap1">Добавить товар</div>
            <form action="/asd.php" method="post" id="form-work" class="wrap-order wrap4" onsubmit="send(this)">
                <table class="order_add w100p">
                    <tr>
                        <td class="w120">Раздел</td>
                        <td>
                            <div class="wrap_select w100p">
                                <label>
                                    <span class="select w100p">                                            
                                        <span class="dropdown"></span>
                                        <select name="section" class="w100p">
                                            <option value="1">Ремонтные хомуты</option>
                                            <option value="2">Свертные хомуты</option>
                                            <option value="3">Зажимные муфты</option>
                                            <option value="new">Добавить новый</option>
                                        </select>                                        
                                    </span>
                                </label>
                            </div>                
                        </td>
                    </tr>
                    <tr>
                        <td class="w120">Подраздел</td>
                        <td>
                            <div class="wrap_select w100p">
                                <label>
                                    <span class="select w100p">                                            
                                        <span class="dropdown"></span>
                                        <select name="subsection" class="w100p">
                                            <option value="1">Хомуты ремонтные оцинкованные "краб"</option>
                                            <option value="new">Добавить новый</option>
                                        </select>                                        
                                    </span>
                                </label>
                            </div>                
                        </td>
                    </tr>
                    <tr>
                        <td class="w120">Наименование</td>
                        <td class="client_name">
                            <input type="text" name="client" id="product-name" class="order_add_client w100p">
                            <ul id="list"></ul>                             
                        </td>
                    </tr>
                    <tr>
                        <td class="w120">Артикул</td>
                        <td>
                            <input type="text" name="article" class="w200">                     
                        </td>
                    </tr>
                    <tr>
                        <td class="w120">Дата начала</td>
                        <td>
                            <input type="text" class="w200 color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="prod-date-start">      
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn right" value="Добавить"></td>
                    </tr>
                </table>
            </form>
            <h1 class="wrap4">Редактирование товаров</h1>
            <form action="/asd.php" method="post" class="w100p wrap4" onsubmit="send(this)">
                    <div id="orders_add" class="wrap_orders_list wrap4">
                        <div class="wrap_prod_change">
                            <div class="prod_header">
                                <div class="w320"></div>
                                <div class="w140 al_left">Артикул</div>
                                <div class="w180">Текущая цена, руб</div>
                                <div class="w180">Новая цена, руб</div>
                                <div class="w150">Дата начала</div>
                            </div>
                                               
                            <div class="prod_section">Ремонтные хомуты</div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Хомуты ремонтные оцинкованные "краб" <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>                     
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled">  
                                        <div class="w320"><input type="text" class="w270" name="name17001" value='1/2"; Ду 15; Дн 20-24; шир.70'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art17001" value="17001"></div>
                                        <div class="w180 al_right"><span class="prod_cell">112.70</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell17001"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from17001"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name17002" value='3/4"; Ду 20; Дн 25-29; шир.70'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art17002" value="17002"></div>  
                                        <div class="w180 al_right"><span class="prod_cell">122.30</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell17002"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from17002"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name17003" value='1"; Ду 25; Дн 32-35; шир.70'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art17003" value="17003"></div>
                                        <div class="w180 al_right"><span class="prod_cell">131.70</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell17003"></div>
                                        <div class="w150 al_right"><input type="text" name="date-from17003" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="prod_section">Свертные хомуты</div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Хомуты свертные оцинкованные "краб" <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18101" value='1-1/4"; Ду 32; Дн 40-44; шир.70'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18101" value="18101"></div>  
                                        <div class="w180 al_right"><span class="prod_cell">825.20</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18101"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18101"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18102" value='Дн 110-118; шир. 162'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18102" value="18102"></div>
                                        <div class="w180 al_right"><span class="prod_cell">893.90</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18102"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18102"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18103" value='Дн 130-139; шир. 162'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18103" value="18103"></div>  
                                        <div class="w180 al_right"><span class="prod_cell">984.80</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell103"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18103"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Хомуты нержавеющие свёртные (один замок) <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18301" value='Ду 90, Дн 101-106; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18301" value="18301"></div>
                                        <div class="w180 al_right"><span class="prod_cell">4190.20</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18301"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18301"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18302" value='Ду 100, Дн 108-114; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18302" value="18302"></div>
                                        <div class="w180 al_right"><span class="prod_cell">4412.90</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18302"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18302"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18303" value='Ду 125, Дн 130-136; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18303" value="18303"></div>  
                                        <div class="w180 al_right"><span class="prod_cell">4988.00</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18303"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18303"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Хомуты нержавеющие свёртные (два замка) <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18302+18303" value='Ду 225, Дн 239-245; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18302+18303" value="18302+18303"></div>
                                        <div class="w180 al_right"><span class="prod_cell">9400.00</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18302+18303"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18302+18303"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name18302+18304" value='Ду 250, Дн 268-274; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18302+18304" value="18302+18304"></div>
                                        <div class="w180 al_right"><span class="prod_cell">9675.00</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18302+18304"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18302+18304"></div>
                                    </div>
                                    <div class="item_prod_rolled"> 
                                        <div class="w320"><input type="text" class="w270" name="name18304+18304" value='Ду 300, Дн 319-325; шир. 250'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art18304+18304" value="18304+18304"></div>
                                        <div class="w180 al_right"><span class="prod_cell">10526.00</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell18304+18304"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from18304+18304"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="prod_section">Зажимные муфты</div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Муфты зажимные наружная резьба <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled"> 
                                        <div class="w320"><input type="text" class="w270" name="name16001" value='1/2"; Ду 15; Дн 19,7-21,8'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16001" value="16001"></div>
                                        <div class="w180 al_right"><span class="prod_cell">349.30</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16001"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16001"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name16002" value='3/4"; Ду 20; Дн 24,6-27,3'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16002" value="16002"></div>
                                        <div class="w180 al_right"><span class="prod_cell">306.90</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16002"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16002"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name16003" value='1"; Ду 25; Дн 31,4-34,2'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16003" value="16003"></div>
                                        <div class="w180 al_right"><span class="prod_cell">388.80</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16003"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16003"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap_prod_subsection">
                                <div class="prod_subsection color_blue">Муфты зажимные внутренняя резьба <div class="dropdown"></div></div>
                                <div class="wrap_prod_startdate w180 al_right"><input type="text" class="prod_startdate_subsection prod_hidden w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()"></div>
                                <div class="clear"></div>
                                <div class="prod_rolled">
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name16007" value='1/2"; Ду 15; Дн 19,7-21,8'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16007" value="16007"></div>
                                        <div class="w180 al_right"><span class="prod_cell">257.40</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16007"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16007"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name16008" value='3/4"; Ду 20; Дн 24,6-27,3'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16008" value="16008"></div>
                                        <div class="w180 al_right"><span class="prod_cell">316.80</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16008"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16008"></div>
                                    </div>
                                    <div class="item_prod_rolled">
                                        <div class="w320"><input type="text" class="w270" name="name16009" value='1"; Ду 25; Дн 31,4-34,2'></div>
                                        <div class="w140 prod_art"><input type="text" class="w90p" name="art16009" value="16009"></div>  
                                        <div class="w180 al_right"><span class="prod_cell">400.50</span></div>
                                        <div class="w180 al_right"><input type="number" class="w90 al_right" name="newcell16009"></div>
                                        <div class="w150 al_right"><input type="text" class="prod_startdate w100 al_right color_blue" readonly="" onclick="xCal(this)" onkeyup="xCal()" name="date-from16009"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="w100p mt20">
                                <div class="right">
                                    <a href="settings.html" class="btn cancel">Отменить</a><input type="submit" class="btn" value="Сохранить">
                                </div>
                                <div class="clear"></div>                          
                            </div>

                        </div>                        
                    </div>                       
            </form>
            <div class="wrap4">
                <h2 class="f17">Операции</h2>
                <table>
                    <tr class="table_item">
                        <td class="date color_grey">07.11.19</td>
                        <td>Изменение 17001 - Петрова О.И.</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">05.10.19</td>
                        <td>Изменение 17003 - Петрова О.И.</td>
                    </tr>
                    <tr class="table_item">
                        <td class="date color_grey">16.06.19</td>
                        <td>Изменение 18001 - Петрова О.И.</td>
                    </tr>
                </table>
            </div>
        </main>