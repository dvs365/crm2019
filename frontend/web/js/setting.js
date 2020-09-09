$(document).ready(function(){

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
    
	//открытие/закрытие распределения клиентов архивных пользователей
    $('input.access').click(function(){
        if ($(this).val() == 0) {
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
	
    $('input#access').click(function(){
        userFunctionsAccess();
    });	
	
	function userFunctionsAccess() {
		if ($('input#access:checked').val() == 1) {
			$('.user_functions input[type=checkbox]').prop('checked', false);
			$('.user_functions label.notbase input[type=checkbox]').attr('disabled', 'disabled');
			$('.user_functions label.notbase').addClass('color_grey');
			$('.user_functions label.notbase .checkbox').addClass('checkbox_disabled');
		}
		if ($('input#access:checked').val() == 2) {
			$('.settings_user input[type=checkbox]').prop('checked', true);
			$('.user_functions label.notbase input[type=checkbox]').removeAttr('disabled');
			$('.user_functions label.notbase').removeClass('color_grey');
			$('.user_functions label.notbase .checkbox').removeClass('checkbox_disabled');
		}
	}
	

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
	
    //отправка запроса на сервер
    function sendAjax(act, met, mas, suc) {
        $.ajax({
           type: met,
           url: act,
           data: mas,
           success: suc
        });
    }
});