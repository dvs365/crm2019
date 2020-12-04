$(document).ready(function(){
	$('#todo-client').select2({
		theme: "classic"
	});
	
	//открыть добавление дела
    $("#open-add-work").click(function(){
        //$(this).removeClass('color_blue');
		if($('#form-work').is(':visible')){
			$('#form-work').animate({'max-height':'0px'}, 200);
			$('#form-work').hide();
		} else {
			$('#form-work').show(0);
			$('#form-work').animate({'max-height':'500px'}, 200);			
		}
    });
	
    $("#toreject").click(function(){
        if($('#formrejectlient').is(':visible')) {
            $('#formrejectlient textarea').animate({'height':0}, 500);
            $('#formrejectlient').hide();
        } else {
            $('#formrejectlient').show();
            $('#formrejectlient textarea').animate({'height':'70px'}, 500);

        }
        return false;
    });

    now = nowDate();
    $('.task_date').val(now);
    $('.task_date__s').val(now);
    wnow = wordMonth(now);
    $('.date_a span').text(wnow);
    $('.comment_date').text(now);

    $('#choise-date').on('click', 'td button', function(){
        adate = wordMonth($('#choise-date').find('.task_date__s').val());
        $('.date_a span').text(adate);
		var form = $('#choise-date');
		var act = form.attr('action');
		var met = form.attr('method');
		var mas = $(form).serializeArray();		
        $.ajax({
            type: met,
            url: act,
            data: mas,
        }).done(function (data) {
            if (data.error == null) {
                $("#act-task").html(data);
            } else {
				alert('error');
                $("#act-task").html(data.error);
            }

        }).fail(function () {
            $("#act-task").html(data.error);
        });
        return false;		
    });

    function wordMonth(adate) {
        mon={'01':'января','02':'февраля','03':'марта','04':'апреля','05':'мая','06':'июня','07':'июля','08':'августа','09':'сентября','10':'октября','11':'ноября','12':'декабря'}
        Day = adate.substring(0,2);
        Year = adate.substring(6,adate.length);
        Month = mon[adate.substring(3,5)];
        return Day + ' ' + Month + ' ' + Year;
    }
	
	//закрыть дело
    $(".task").on('click', 'button',  function(){
        var form = $(this).parent(".toclose");
        var href = form.attr('action');
        var td = form.parent();
        td.parent("tr.table_item").parent().parent().parent("div.task_item").remove();
        sendAjax(href, "POST")
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
	
    $(".task_comment").each(function(){
        if ($(this).height() >= 100) {
            $(this).find(".task_comment_gradient").css({'display':'block'});
        }
    })

    $(".task_comment_gradient").click(function(){
        $(this).closest('.task_comment').animate({'max-height':'9999px'}, 500);
        $(this).remove();
    });	
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

//обработка формы
function send(form) {
	event.preventDefault();
	act = form.action;
	met = form.method;
	mas = $(form).serializeArray();
	name = $(form).find(':submit').attr('name');
	suc = function(html){
		alert(html);
	};
	mas.push({ name: name, value: '' });
	sendAjax(act, met, mas, suc);
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