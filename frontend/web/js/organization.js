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
});	