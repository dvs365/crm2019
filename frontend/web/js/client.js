$(document).ready(function(){
    //согласовать цену
    $(".agreed").click(function(){
        event.preventDefault();
        $(this).parent().children('.agreed_none').removeClass('agreed_none');
        $(this).remove();
        sendAjax($(this).attr('href'), "POST");
    });

    //добавить дело по клиенту formtodoclient
    $("#formtodoclient").on('beforeSubmit', function () {
        var $testform = $(this);
        var met = $testform.attr('method');
        var act = $testform.attr('action');
        var mas = $testform.serializeArray();
        var suc = $("#outputtodo");
        $.ajax({
            type: met,
            url: act,
            data: mas,
        }).done(function (data) {
            if (data.error == null) {
                $("#outputtodo").html(data);
                $("#formtodoclient input[type=text]#todo-name").val('');
                $("#formtodoclient textarea").val('');
            } else {
				alert('error');
                $("#outputtodo").html(data.error);
            }

        }).fail(function () {
            $("#outputtodo").html(data.error);
        });
        return false;
    });
	
    $("#formcomment").on('beforeSubmit', function () {
        var $testform = $(this);
        var met = $testform.attr('method');
        var act = $testform.attr('action');
        var mas = $testform.serializeArray();
        var suc = $("#comments div table");
        $.ajax({
            type: met,
            url: act,
            data: mas,
        }).done(function (data) {
            if (data.error == null) {
                $testform.find('textarea').val('');
                $("#comments div table").prepend(data);
            } else {
                $("#comments div table").prepend(data.error);
            }

        }).fail(function () {
            $("#commentsTable").prepend("Error3");
        });
        return false;
    });

    //открыть 10 комментариев
    $("#comment-open10").click(function(){
        event.preventDefault();
        var met = 'post';
        var act = $('#comment-open10').attr('href');
        var cnt = $('#commentsTable tr').length;
        var mas = 'count=' + $('#commentsTable tr').length;
        $.ajax({
            type: met,
            url: act,
            data: mas,
        }).done(function (data) {
            if (data.error == null) {
                $("#comments div table").append(data);
                var newcnt = ($('#commentsTable tr').length - cnt);
                if(newcnt != 10){
                    $("#comment-open10").hide();
                    $("#comment-openall").hide();
                }
            } else {
                $("#comments div table").append(data.error);
            }
        }).fail(function () {
            $("#comments div table").append("Error3");
        });
        return false;
    });
    //открыть все комментарии
    $("#comment-openall").click(function(){
        event.preventDefault();
        var met = 'post';
        var act = $('#comment-open10').attr('href');
        var cnt = $('#commentsTable tr').length;
        var mas = 'count=' + $('#commentsTable tr').length + '&all=1'
        $.ajax({
            type: met,
            url: act,
            data: mas,
        }).done(function (data) {
            if (data.error == null) {
                $("#comments div table").append(data);
                $("#comment-open10").hide();
                $("#comment-openall").hide();
            } else {
                $("#comments div table").append(data.error);
            }
        }).fail(function () {
            $("#comments div table").append("Error3");
        });
        return false;
    });

    //удалить дело по клиенту//parent добавленного элемента не видит дальнего родителя
    $("#outputtodo").on('click', 'button',  function(){
        var form = $(this).parent(".todoclientdelete");
        var href = form.attr('action');
        var td = form.parent();
        td.parent("tr.table_item").parent().parent().parent("div.task_item").remove();
        sendAjax(href, "GET")
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

    //раскрытие причины отказа
    $("#refusal").click(function(){
        event.preventDefault();
        $(this).css({'color':'#000', 'cursor':'default'});
        $('#refusal-case').css({'z-index':'1'});
        $('#refusal-case').animate({'opacity':'1', 'max-height':'500px'}, 200);
    });

    //раскрытие комментария к делу
    $("#outputtodo").on('click','td.open_desc',function(){
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
	
    //раскрытие поля для заметки
    $("#note-open").click(function(){
        $(this).hide('fast');
        $(this).parent().children('.note').show('fast');
    });

    $("#formnote").on('beforeSubmit', function () {
        var $testform = $(this);
        var met = $testform.attr('method');
        var act = $testform.attr('action');
        $.ajax({
            type: met,
            url: act,
            data: 'note=' + $("#formnote textarea#client-note").val(),
        }).done(function (data) {
            if (data.error == null) {
                console.log(data.data);
                $("#note-open").html(data.data);
            } else {
                $("#note-open").html(data.error);
            }

        }).fail(function () {
            $("#note-open").html("Error3");
        });
        $("#formnote").hide();
        $("#note-open").show();
        return false;
    });

    //раскрытие формы добавление дела
    $("#open-add-work").click(function(){
        $(this).removeClass('color_blue');
        $('#form-work').show(0);
        $('#form-work').find('textarea').each(function(){
            autoChangeTextarea($(this));
        })
        $('#form-work').animate({'max-height':'500px'}, 200);
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
    });

    $('input[name=select-all]').click(function(){
        if ($(this).is(':checked')) $('#elements input:checkbox').prop('checked', true);
        else $('#elements input:checkbox').prop('checked', false);
    });

    function wordMonth(adate) {
        mon={'01':'января','02':'февраля','03':'марта','04':'апреля','05':'мая','06':'июня','07':'июля','08':'августа','09':'сентября','10':'октября','11':'ноября','12':'декабря'}
        Day = adate.substring(0,2);
        Year = adate.substring(6,adate.length);
        Month = mon[adate.substring(3,5)];
        return Day + ' ' + Month + ' ' + Year;
    }
	
    $(".task_comment").each(function(){
        if ($(this).height() >= 100) {
            $(this).find(".task_comment_gradient").css({'display':'block'});
        }
    })

    $(".task_comment_gradient").click(function(){
        $(this).closest('.task_comment').animate({'max-height':'9999px'}, 500);
        $(this).remove();
    });
	
    $('main').on('keypress keyup click', '.autoheight', function(event){
        autoChangeTextarea($(this));
    })
    $('main').find('.autoheight').each(function(){
        autoChangeTextarea($(this));
    });	
});
//отправка запроса на сервер
function sendAjax(act, met, mas, suc) {
	$.ajax({
	   type: met,
	   url: act,
	   data: mas,
	   success: suc
	});
}

//расширить textarea
function autoChangeTextarea(block) {
    if (block.hasClass('h36')) mh = 28;
    else mh = 48;
    fake = block.parent().parent().children('.fake_textarea');
    fake.width(block.width());
    str = block.val();
    str = str.replace(/</g,"_").replace(/\n/g,"<br>").replace(/  /g,"&ensp;");
    fake.html(str);
    if ((fake.height()+8) < (mh + 1)) return false;
    else if ((fake.height()+8) != mh) block.css({'height': (fake.height() + 8)+'px'}, 200);
}

//изменить дело по клиенту formtodoclient
function changeTask(i) {
	var met = $(i).parent().attr('method');
	var act = $(i).parent().attr('action');
	var mas = $(i).parent().serializeArray();
	var suc = $("#outputtodo");
	$.ajax({
		type: met,
		url: act,
		data: mas,
	}).done(function (data) {
		if (data.error == null) {
			$("#outputtodo").html(data);
		} else {
			alert('error');
			$("#outputtodo").html(data.error);
		}
	}).fail(function () {
		$("#outputtodo").html(data.error);
	});
	return false;
}

//раскрытие редактирования дела
function openChangeTask(i){
	event.preventDefault();
	block = $(i).closest('.task_item');
	block.find('form.task_change').show(200);
	setTimeout(function(){
		block.find('textarea.autoheight').each(function(){
			autoChangeTextarea($(i));
		})
	},200);
}	