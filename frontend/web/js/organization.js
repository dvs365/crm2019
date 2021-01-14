$(document).ready(function(){
    //раскрытие редактирования фирмы
    $("#open-firm-change").click(function(){
        $(this).removeClass('color_blue');
        $('.firm_item').animate({'height':'0'}, 500);
        $('.firm_item_change').show(0);
        $('.firm_item_change').animate({'max-height':'9999px'}, 500);
        setTimeout(function(){
            $('.firm_item').hide(0);
        }, 500);
    });
    //закрытие редактирования фирмы
    $("#close-firm-change").click(function(){
        $("#open-firm-change").addClass('color_blue');
		$('.firm_item').css('height','');
        $('.firm_item').show(0);
		$('.firm_item_change').hide(600);
    });	
});	