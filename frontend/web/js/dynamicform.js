jQuery(function ($) {
    $(this).find(".item_client_phone:first td:first").html('Телефон');
    $(this).find(".item_client_mail:first td:first").html('E-mail');
	$(this).find(".client_delivery_item:first td:first").html('Адрес доставки');

    $(".dynamicform_wrapper_client_phone tr:not(:last-child) td:last-child .add-cphone").hide();
    $(".dynamicform_wrapper_client_mail tr:not(:last-child) td:last-child .add-cmail").hide();
	$(".dynamicform_wrapper_client_delivery tr:not(:last-child) td:last-child .add-address").hide();

    $(".dynamicform_wrfphone tr:not(:last-child) td:last-child .add-fphone").hide();
    $(".dynamicform_wrfmail tr:not(:last-child) td:last-child .add-fmail").hide();

    $(".client_add").on('click', '[class*="add-"]', function() {
        $(this).hide();
    });

    $(".dynamicform_wrapper_client_phone").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });
    $(".dynamicform_wrapper_client_mail").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });
    $(".dynamicform_wrfphone").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });
    $(".dynamicform_wrfmail").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });

    $(".dynamicform_wrface").on("afterInsert", function (e, item) {
        //$(item).find(".fphone-item td:first").html('Телефон');
        //$(item).find(".fmail-item td:first").html('E-mail');
        var pers_num_old = Number($(item).prev('.face-item').find('.client_item_number').text());
        var pers_num_new = pers_num_old + 1;
        $(item).find('.client_item_number').text(pers_num_new);
		$(item).find('.main-contact-person').val(pers_num_new);
    });

    $(".dynamicform_wrapper_client_org").on("afterInsert", function (e, item) {
        var pers_num_old = Number($(item).prev('.client_org_item').find('.client_item_number').text());
        var pers_num_new = pers_num_old + 1;
        $(item).find('.client_item_number').text(pers_num_new);
        //$(item).find('.wrap_third input[type=radio]:first').attr('checked', 'checked');
    });

    //изменение граф в случае выбора ИП
    $(".client_add").on('change', '.select_property select', function(){
        if ($(this).val() == 60) {
            $(this).closest('table').find('tr.kpp').hide('fast');
            $(this).closest('table').find('td.ogrn').text('ОГРНИП');
        } else {
            $(this).closest('table').find('tr.kpp').show('fast');
            $(this).closest('table').find('td.ogrn').text('ОГРН');
        }
    });
});