$(document).ready(function(){
    //согласовать цену
    $(".agreed").click(function(){
        event.preventDefault();
        $(this).parent().children('.agreed_none').removeClass('agreed_none');
        $(this).remove();
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
});