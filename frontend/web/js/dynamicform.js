jQuery(function ($) {
    $(this).find(".item_client_face_phone:first td:first").html('Телефон');
    $(this).find(".item_client_face_mail:first td:first").html('E-mail');

    $(".client_add").on('click', '[class*="add-item_client"]', function() {
        $(this).hide();
    });

    $(".dynamicform_wrapper_client_phone").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });
    $(".dynamicform_wrapper_client_mail").on("afterInsert", function (e, item) {
        $(item).children("td:first").empty();
    });

    $(".dynamicform_wrapper_client_face").on("afterInsert", function (e, item) {
        $(item).find(".item_client_face_phone td:first").html('Телефон');
        $(item).find(".item_client_face_mail td:first").html('E-mail');
        var pers_num_old = Number($(item).prev('.client_face_item').find('.client_item_number').text());
        var pers_num_new = pers_num_old + 1;
        $(item).find('.client_item_number').text(pers_num_new);
    });

    $(".dynamicform_wrapper_client_org").on("afterInsert", function (e, item) {
        var pers_num_old = Number($(item).prev('.client_org_item').find('.client_item_number').text());
        var pers_num_new = pers_num_old + 1;
        $(item).find('.client_item_number').text(pers_num_new);
    });
});