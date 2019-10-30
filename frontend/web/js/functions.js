$(document).ready(function(){
    //согласовать цену
    $(".agreed").click(function(){
        event.preventDefault();
        $(this).parent().children('.agreed_none').removeClass('agreed_none');
        $(this).remove();
        /*sendAjax($(this).attr('href'), "POST");*/
    });

    $("#send-code").click(function(){
        event.preventDefault();
        /*sendAjax($(this).attr('href'), "POST");*/
    });

    //раскрытие общих контактов
    $("#contact-all").click(function(){
        if ($(this).parent().children('.contact_all').is(':visible')) {
            $("#contact-all").find('.dropdown').css({'transform': 'rotate(0deg)'});
        } else {
            $("#contact-all").find('.dropdown').css({'transform': 'rotate(180deg)'});
        }
        $(this).parent().children('.contact_all').toggle('fast');
    });

    //раскрытие комментария к задаче
    $(".task_desc").click(function(){
        $(this).hide();
        $('#task-comment').show();
        $('.task_time').show();
        $('#task-comment').animate({
            'height':'70px'
        }, 500);
    });


    //раскрытие комментария к делу
    $(".open_desc").click(function(){
        hheight = $(this).closest('table').height();
        if ($(this).parent().parent().children('.table_item_hidden').is(':visible')) {
            $(this).closest('table').css({'min-height':hheight});
            $(this).closest('table').animate({'min-height':0}, 500);
        } else {
            $(this).closest('table').css({'max-height':hheight});
            $(this).closest('table').animate({'max-height':hheight+1000}, 500);
        }
        $(this).parent().parent().children('.table_item_hidden').toggle();

    });

    //закрытие дела
    $(".task_item td form").click(function(){
        $(this).closest('.task_item').hide('fast');
    });

    //открыть 10 комментариев
    $("#comment-open10").click(function(){
        event.preventDefault();
        openComments($(this));
    });

    //открыть все комментарии
    $("#comment-openall").click(function(){
        $(this).hide();
        $("#comment-open10").hide('fast');
        event.preventDefault();
        openComments($(this));
    });

    //раскрытие поля для заметки
    $("#note-open").click(function(){
        $(this).hide('fast');
        $(this).parent().children('.note').show('fast');
    });

    //раскрытие формы добавление дела
    $("#open-add-work").click(function(){
        $(this).removeClass('color_blue');
        $('#form-work').show(0);
        $('#form-work').animate({'max-height':'500px'}, 200);
    });

    $("#client-name").focus(function(){
        $("#client-name").keyup(function(){
            a = $("#client-name").val();
            //ответ сервера
            html = '<li class="color_blue"><input type="hidden" value="Меридиан">Меридиан</li>';
            html += '<li class="color_blue"><input type="hidden" value="СанТехАрматура (Долгопрудный)">СанТехАрматура (Долгопрудный)</li>';
            html += '<li class="color_blue"><input type="hidden" value="ООО Термит-ОПТ">ООО "Термит-ОПТ"</li>';
            html += '<li class="color_blue"><input type="hidden" value="Меридиан">Меридиан</li>';
            html += '<li class="color_blue"><input type="hidden" value="СанТехАрматура (Долгопрудный)">СанТехАрматура (Долгопрудный)</li>';
            html += '<li class="color_blue"><input type="hidden" value="ООО Термит-ОПТ">ООО "Термит-ОПТ"</li>';
            if (a.length > 2) {
                $('#list').show('fast');
                $('#list').html(html);
                /*act = 'asd.php';
                met = 'POST';
                mas = {query:a};
                suc= function(html){
                        $('#list').show('fast');
                        $('#list').html(html);
                    };
                sendAjax(act, met, mas, suc);*/
            }
        });
    });
    $("#client-name").blur(function(){
        $('#list').hide('fast');
        $('#list').html('');
    });

    $('#list').on('mousedown', function() {
        return false;
    });
    $("#list").on('click', 'li', function(){
        input = document.getElementById('client-name');
        input.focus();
        vval = $(this).children('input').val();
        $("#client-name").val(vval);
        $('#list').hide('fast');
        $('#list').html('');
    });



    //Добавление | в input
    $('#slash').on('mousedown', function() {
        return false;
    });
    $('#slash').click(function(){
        input = document.getElementById('search');
        start = input.selectionStart;
        end = input.selectionEnd;
        text = input.value.substring(0, start) + '|' + input.value.substring(end);
        input.value = text;
        input.focus();
        input.selectionEnd = start + 1;
    });

    $('#sort button').click(function(){
        if (($(this).parent().find('input[name="sort"]')).is(':checked')){
            $(this).parent().find('input[name="sort"]').prop('checked', false);
        } else $(this).parent().find('input[name="sort"]').prop('checked', true);
    });

    //скролл наверх
    $('#up').click(function(){
        $("html,body").animate({ scrollTop: 0 }, 'fast');
    });

    $('.btn_menu').click(function(){
        $("nav .right").toggle('fast');
    });

    $('.inner').scroll(function(){
        a = $('.inner').scrollLeft();
        $('tr.tweek_frow').scrollLeft(a);
    });

    //получение сегодняшней даты в формате dd.mm.yyyy
    function nowDate() {
        var now = new Date();
        Year = now.getFullYear();
        Month = now.getMonth();
        Day = now.getDate();
        Month = Month + 1;
        if (Month < 10) Month = '0' + Month;
        if (Day < 10) Day = '0' + Day;
        return Day + '.' + Month + '.' + Year;
    }

    now = nowDate();
    $('.task_date').val(now);
    $('.task_date__s').val(now);
    wnow = wordMonth(now);
    $('.date_a span').text(wnow);
    $('.comment_date').text(now);

    $('#choise-date').on('click', 'td button', function(){
        adate =wordMonth($('#choise-date').find('.task_date__s').val());
        $('.date_a span').text(adate);
    })

    function wordMonth(adate) {
        mon={'01':'января','02':'февраля','03':'марта','04':'апреля','05':'мая','06':'июня','07':'июля','08':'августа','09':'сентября','10':'октября','11':'ноября','12':'декабря'}
        Day = adate.substring(0,2);
        Year = adate.substring(6,adate.length);
        Month = mon[adate.substring(3,5)];
        return Day + ' ' + Month + ' ' + Year;
    }

    //добавить организацию / контактное лицо
    $('.client_item_add').click(function(){
        text = '<div class="client_item none">'+($(this).prev('.client_item').html())+'</div>';
        $(this).prev('.client_item').after(text);
        pers_num_old = Number($(this).prev('.client_item').find('.client_item_number').text());
        pers_num_new = pers_num_old + 1;
        $(this).prev('.client_item').find('.client_item_number').text(pers_num_new);
        per1 = '[' + pers_num_old + ']';
        per2 = '[' + pers_num_new + ']';

        $(this).prev('.client_item').find('input[type="text"]').each(function(i){
            $(this).attr('name', $(this).attr('name').replace(per1, per2));
        });
        $(this).prev('.client_item').find('select').each(function(i){
            $(this).attr('name', $(this).attr('name').replace(per1, per2));
        });
        $(this).prev('.client_item').find('input[type="radio"]').each(function(i){
            $(this).attr('name', $(this).attr('name').replace(per1, per2));
        });
        $(this).prev('.client_item').show('fast');
    });

    //добавить контакт клиента
    $(".client_add").on('click', '.contact_add', function(){
        $(this).hide();
        id = Number($(this).parent('td').children('input[name="id"]').val());
        num = Number($(this).parent('td').children('input[name="contact_number"]').val()) + 1;

        switch (id) {
            case 1:
                text = '<tr class="none"><td></td><td><input type="hidden" name="contact_number" value="'+num+'"><input type="hidden" name="id" value="1"><input type="text" class="phone_number" name="phone['+num+']" placeholder="+7"><input type="text" class="phone_comment" name="phone_comment['+num+']" placeholder="Комментарий к телефону"><div class="btn right contact_add">Добавить</div></td></tr>';
                break;
            case 2:
                text = '<tr class="none"><td></td><td><input type="hidden" name="contact_number" value="'+num+'"><input type="hidden" name="id" value="2"><input type="text" class="mail" name="mail['+num+']"><div class="btn right contact_add">Добавить</div></td></tr>';
                break;
            case 3:
                pers_num = Number($(this).closest('.client_item').find('.client_item_number').text());
                text = '<tr class="none"><td></td><td><input type="hidden" name="contact_number" value="'+num+'"><input type="hidden" name="id" value="3"><input type="text" class="phone_number" name="person-phone['+pers_num+']['+num+']" placeholder="+7"><input type="text" class="phone_comment" name="person-phone-comment['+pers_num+']['+num+']" placeholder="Комментарий к телефону"><div class="btn right contact_add">Добавить</div><div class="clear"></div></td></tr>';
                break;
            case 4:
                pers_num = Number($(this).closest('.client_item').find('.client_item_number').text());
                text = '<tr class="none"><td></td><td><input type="hidden" name="contact_number" value="'+num+'"><input type="hidden" name="id" value="4"><input type="text" class="mail" name="person-mail['+pers_num+']['+num+']"><div class="btn right contact_add">Добавить</div><div class="clear"></div></td></tr>';
                break;
        }
        $(this).closest('tr').after(text);
        $(this).closest('tr').next('tr').show('fast');
    });

    //изменение граф в случае выбора ИП
    $(".client_add").on('change', '.select_property select', function(){
        if ($(this).val() == 6) {
            $(this).closest('table').find('tr.kpp').hide('fast');
            $(this).closest('table').find('td.ogrn').text('ОГРНИП');
        } else {
            $(this).closest('table').find('tr.kpp').show('fast');
            $(this).closest('table').find('td.ogrn').text('ОГРН');
        }
    });

    //раскрытие изменения пароля
    $('#password-change').click(function(){
        $(this).next('.password_change').show(200);
        $(this).removeClass('color_blue');
        $(this).text('Изменение пароля:');
    });

    //открытие/закрытие select multiple
    $('#choise_user .dropdown').click(function(){
        if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $('.choise_user').toggle(100);
            h1 = $('.choise_user').find('option').outerHeight();
            col = $('.choise_user').find('option').length;
            hheight = h1 * col;
            if (hheight < 200) $('.choise_user select').height(hheight);
        }
    });
    $('html').on('click', 'body', function(e){
        if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            var div = $('#choise_user');
            if (!div.is(e.target) && div.has(e.target).length === 0) {
                $('.choise_user').hide();
            }
        }
    });

    //обработка select multiple по клику мыши
    $('#choise_user').on('mousedown', 'select option', function(){
        event.preventDefault();
        if (this.selected==false) this.selected=true;
        else this.selected=false;
    });
    var selected = new Array();
    $('#choise_user').on('blur', 'select', function(){
        var a = 0;
        var text = '';
        $(this).children('option').each(function(){
            if ($(this).is(':selected')) {
                if (a>0) text += ', ' + $(this).text()
                else text += $(this).text();
                a++;
            }
            $('.users_choised').text(text);
        });
    });

    //открытие/закрытие распределения клиентов архтвных пользователей
    $('input[name=status-user]').click(function(){
        if ($(this).val() == 2) {
            $('#status-archive').animate({
                'max-height':'1000px'
            }, 400);
            setTimeout(function() {
                $('#status-archive').css({'overflow':'visible'});
            },400);
            col = Number($('#clients_col').text());
            if (col==0) $('#distribution').hide();

        } else {
            $('#status-archive').animate({
                'max-height':'0'
            }, 400);
            setTimeout(function() {
                $('#status-archive').css({'overflow':'hidden'});
            },400);
        }
    });

    $('input[class=access]').click(function(){
        userFunctionsAccess();
    });

    //объединение ячеек (настройки - добавление/редактирование пользователя)
    if ($(window).width() < 481) {
        $('td.w180.cl480').hide();
        $('td.settings_user.cl480').attr('colspan', '2')
    }

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#choise_user .choise_user').css({'display':'block', 'min-height':'0', 'height':'100%', 'background-color':'transparent', 'top':'0', 'border':'none'});
        $('.choise_user select').css({'min-height':'0', 'height':'100%'});
        $('#choise_user .users_choised').css({'display':'none'});
    };
});

//обработка формы
function send(form) {
    event.preventDefault();
    act = form.action;
    met = form.method;
    mas = $(form).serializeArray();
    sendAjax(act, met, mas);
}

//отправка запроса на сервер
function sendAjax(act, met, mas, suc) {
    $.ajax({
        type: met,
        url: act,
        data: mas,
        success: suc
    });
}

//открытие комментариев
function openComments(elem) {

    hheight = elem.parent('.comments').children('div.wrap3').height();
    elem.parent('.comments').children('div.wrap3').css({'max-height':hheight});
    /*met = "POST";
    act = elem.attr('href');
    mas = [];
    suc = function(html){
            html = '<tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr>';
            $('.comments table').append(html);
        };
    sendAjax(act, met, mas, suc);*/
    //ответ от сервера
    html = '<tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">07.06</td><td>отгр муфт 20% и немного хом 10% на 56 тыр на Меридиан.</td></tr><tr class="table_item"><td class="date color_grey this_year">25.03</td><td>отгр на Аквастрой муфт 20% и немного хом 10% на 47 тыр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr><tr class="table_item"><td class="date color_grey this_year">09.01</td><td>обн прайс, закажет по потр</td></tr>';
    $('.comments table').append(html);
    elem.parent('.comments').children('div.wrap3').animate({'max-height':hheight+1000}, 500);
}

function validatePass(form) {
    newpass = $(form).find('input[name=new-password]').val();
    var str = /[a-z]/g;
    var zag = /[A-Z]/g;
    var num = /[0-9]/g;
    var sim = /[-+=!@?#$%^&*()_\|/.,:;{}]/g;
    var err = '';
    if (newpass.length < 8) err += 'Пароль должен состоять как минимум из восьми символов<br>';
    if (!newpass.match(str)) err += 'В пароле должна быть строчная буква<br>';
    if (!newpass.match(zag)) err += 'В пароле должна быть заглавная буква<br>';
    if (!newpass.match(num)) err += 'В пароле должна быть цифра<br>';
    if (!newpass.match(sim)) err += 'В пароле должен быть символ<br>';
    if ($('input').is('[name=new-password-r]')) {
        newpassr = $(form).find('input[name=new-password-r]').val();
        if (newpass != newpassr) err += 'Пароли не совпадают';
    }
    if (err) {
        $(form).find('.error').html('<div class="wrap1">' + err + '</div>');
        return false
    } else return true

}

function validatePassInput(input) {
    newpass = $(input).val();
    var str = /[a-z]/g;
    var zag = /[A-Z]/g;
    var num = /[0-9]/g;
    var sim = /[-+=!@?#$%^&*()_\|/.,:;{}]/g;
    var err = '';
    if (newpass.length < 8) err += 'Пароль должен состоять как минимум из восьми символов<br>';
    if (!newpass.match(str)) err += 'В пароле должна быть строчная буква<br>';
    if (!newpass.match(zag)) err += 'В пароле должна быть заглавная буква<br>';
    if (!newpass.match(num)) err += 'В пароле должна быть цифра<br>';
    if (!newpass.match(sim)) err += 'В пароле должен быть символ<br>';
    $('.error').html('<div class="wrap1">' + err + '</div>');
    if (err) {
        return false
    } else return true
}

function userFunctionsAccess() {
    if ($('input[class=access]:checked').val() == 1) {
        $('.user_functions input[type=checkbox]').prop('checked', false);
        $('.user_functions label:nth-child(1) input[type=checkbox], .user_functions label:nth-child(2) input[type=checkbox]').attr('disabled', 'disabled');
        $('.user_functions label:nth-child(1), .user_functions label:nth-child(2)').addClass('color_grey');
        $('.user_functions label:nth-child(1) .checkbox, .user_functions label:nth-child(2) .checkbox').addClass('checkbox_disabled');
    }
    if ($('input[class=access]:checked').val() == 2) {
        $('.settings_user input[type=checkbox]').prop('checked', true);
        $('.user_functions label:nth-child(1) input[type=checkbox], .user_functions label:nth-child(2) input[type=checkbox]').removeAttr('disabled');
        $('.user_functions label:nth-child(1), .user_functions label:nth-child(2)').removeClass('color_grey');
        $('.user_functions label:nth-child(1) .checkbox, .user_functions label:nth-child(2) .checkbox').removeClass('checkbox_disabled');
    }
}