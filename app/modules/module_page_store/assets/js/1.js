function sendAjax(id, params) {
    $.ajax({
        url: location.href,
        type: 'post',
        data: $('#' + id).serialize() + "&button=" + id + "&params=" + params,
        success: function (response) {
            let jsonData = JSON.parse(response);
            console.log(jsonData);
            if (typeof jsonData.error === 'undefined') {
                switch (id) {
                    case 'edit-ajax-server':
                        editServerTableInfo(jsonData);
                        showShopTable('shop_table_edit_server');
                        return;
                    case 'edit-ajax-promo':
                        editPromoTableInfo(jsonData);
                        showShopTable('shop_edit_promo');
                        return;
                    case 'edit-ajax-cat':
                        editCategoryTableInfo(jsonData);
                        showShopTable('shop_edit_cat');
                        return;
                    case 'discount':
                        success(jsonData.success, 2, 0);
                        return;
                    case 'get-ajax-table':
                        editPropertyTable(params, jsonData);
                        openPropertyTable(params);
                        return;
                    case 'delete-table-property':
                        removeTableProperty(params, 'table');
                        return;
                    case 'delete-card-property':
                        removeTableProperty(params, 'card');
                        return;
                    case 'edit-table-property_' + params:
                        changePropertyFieldDone(params, jsonData['product_id'], 'table');
                        return;
                    case 'edit-card-property_' + params:
                        changePropertyFieldDone(params, jsonData['product_id'], 'card');
                        return;
                    case 'create-option-price':
                        createOptionPrice(params, jsonData);
                        return;
                    case 'create-table-property_' + id.split('_')[1]:
                        deleteCreatePropertyFields(id.split('_')[1]);
                        let property_table = createProperty(jsonData.id, jsonData.product_id, jsonData.active, jsonData.title, jsonData.sort);
                        $('.shop_table_fix').before(property_table);
                        return;
                    case 'create-card-property_' + id.split('_')[1]:
                        deleteCreatePropertyFields(id.split('_')[1], 'card');
                        let property_card = createProperty(jsonData.id, jsonData.product_id, jsonData.active, jsonData.title, jsonData.sort, 'card');
                        $('.shop_card_fix_' + params).before(property_card);
                        return;
                    case 'edit-ajax-price-options':
                        fillEditPriceOptionsTable(jsonData);
                        showShopTable('shop_table_edit_price');
                        return;
                    case 'delete-product':
                        deleteProduct(params);
                        success(jsonData.success, 2, 0);
                        return;
                    case 'edit-ajax-product':
                        changeEditProductTable(jsonData);
                    case 'add-product-basket':
                        success(jsonData.success, 2, 0);
                        BasketCount();
                        return;
                    case 'delete-product-basket':
                        deleteProductInBasket(params);
                        return;
                    case 'pay-order':
                        payOrder(jsonData);
                }
            }

            if (!(typeof jsonData.error === 'undefined')) {
                error(jsonData.error);
            } else if (!(typeof jsonData.success === 'undefined')) {
                success(jsonData.success);
            }
        },
    });
    return false;
}

function payOrder(data) {
    if (!(typeof data.url === 'undefined')) {
        window.location.replace(data.url);
    }
}

function deleteProductInBasket(id) {
    $('.shop_basket_item_' + id).remove();
    if ($('.shop_basket_item').length == 0) {
        $('#pay-button').removeAttr('onclick');;
    }
}

function BasketCount() {
    let countElement = document.querySelector('.count_basket');
    if (countElement) {
        let currentValue = parseInt(countElement.textContent);
        let newValue = currentValue + 1;
        countElement.textContent = newValue;
    }
}

function error(data, time = 4, timeout = 0) {
    noty(data, 'error', '/storage/assets/sounds/error.mp3', 0.1);

    if (timeout !== 0) {
        setTimeout(function () {
            window.location = window.location.href
        }, timeout);
    }
}

function success(data, time = 2, timeout = 2000) {
    noty(data, 'success', '/storage/assets/sounds/success2.mp3', 0.1);

    if (timeout !== 0) {
        setTimeout(function () {
            window.location = window.location.href
        }, timeout);
    }
}

function changeEditProductTable(data) {
    $('.shop_table_edit_card').attr('data-value', data.id);
    if (data.status == "0") {
        $('#status_edit').prop('checked', false);
    } else {
        $('#status_edit').prop('checked', true);
    }
    $('#type_edit').val(data.type);
    $('#category_edit').val(data.category);
    $('#title_edit').val(data.title);
    $('#sort_edit').val(data.sort);
    if (data.title_show == "0") {
        $('#title_show_edit').prop('checked', false);
    } else {
        $('#title_show_edit').prop('checked', true);
    }
    $('#value_edit').val(data.value);
    $('#discount_edit').val(data.discount);
    $('#server_id_edit').val(data.server_id);
    $('#server_id_edit_copy').val(data.server_id);
    if (data.table_status == "0") {
        $('#table_status_edit').prop('checked', false);
    } else {
        $('#table_status_edit').prop('checked', true);
    }
    $('#color_edit').val(data.color);
    document.querySelector('#color_edit').jscolor.fromString(data.color);
    $('#img_edit').val(data.img);
    $('#badge_edit').val(data.badge);
    $('#color_edit').attr('data-current-color', data.color);
    jscolor.trigger('input');
    showShopTable('shop_table_edit_card');
}

function changeProductsForServer(serverId) {
    $('.shop_card_wrapper').fadeOut();
    $('.shop_product_server_' + serverId).fadeIn();
}

function deleteProduct(productId) {
    $('.shop_card_wrapper_' + productId).remove();
}

function fillEditPriceOptionsTable(data) {
    $('.shop_table_edit_price').attr('data-value', data.id);
    $('#shop_edit_price_price').val(data.price);
    $('#shop_edit_price_product_id').val(data.product_id);
    for (let i in data.options) {
        if (i != "all_servers") {
            $('#shop_edit_price_' + i).val(data.options[i]);
        } else {
            if (data.options[i] == "0") {
                $('#shop_edit_price_all_servers').prop('checked', false);
            } else {
                $('#shop_edit_price_all_servers').prop('checked', true);
            }
        }
    }
    let type = mapType.get($('#shop_product_' + data.product_id).attr('data-type'));
    $('#edit-price-options').children('.shop_label_price').fadeOut();
    $('#edit-price-options').children('.shop_price_options').fadeOut();
    $('#edit-price-options').children('.shop_tx_0').fadeIn();
    $('#edit-price-options').children('.shop_tx_' + type).fadeIn();
}

function scrollToBottom(element) {
    element.scroll({ top: element.scrollHeight, behavior: 'smooth' });
}

function editPropertyTable(id, data) {
    let productTitle = $('.shop_product_title_' + id).text();
    let title = "<div class='shop_product_gradient_text shop_product_gradient_" + id + " shop_product_table_title'>" + productTitle + "</div>";
    $('#properties_table').attr('data-value', id);
    $('.shop_product_table_title').remove();
    $('.shop_table_property').remove();
    $('.close_properties_table').after(title);

    for (let i in data[id]) {
        let property = createProperty(data[id][i].id, id, data[id][i].active, data[id][i].title, data[id][i].sort);
        $('.shop_table_fix').before(property);
    }
}

function createProperty(id, serverId, active, title, sort, type = 'table') {
    let className = active == 1 ? '' : 'shop_product_property_disabled';
    let svg = active == 1 ? '<svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve"><g><path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path></g></svg>' : '<svg class="property_icon_dsb" x="0" y="0" viewBox="0 0 174.239 174.239" xml:space="preserve"><g><path d="M146.537 1.047a3.6 3.6 0 0 0-5.077 0L89.658 52.849a3.6 3.6 0 0 1-5.077 0L32.78 1.047a3.6 3.6 0 0 0-5.077 0L1.047 27.702a3.6 3.6 0 0 0 0 5.077l51.802 51.802a3.6 3.6 0 0 1 0 5.077L1.047 141.46a3.6 3.6 0 0 0 0 5.077l26.655 26.655a3.6 3.6 0 0 0 5.077 0l51.802-51.802a3.6 3.6 0 0 1 5.077 0l51.801 51.801a3.6 3.6 0 0 0 5.077 0l26.655-26.655a3.6 3.6 0 0 0 0-5.077L121.39 89.658a3.6 3.6 0 0 1 0-5.077l51.801-51.801a3.6 3.6 0 0 0 0-5.077L146.537 1.047z"></path></g></svg>';
    let result =
        '<form id="edit-' + type + '-property_' + id + '" data-sort="' + sort + '"' + 'class="shop_product_property ' + className + ' shop_table_property">' +
        '<div class="shop_sort_property"><input type="number" name="sort" min="1" value="' + sort + '" readonly></div>' +
        '<div class="shop_product_' + type + '_property_icon_delete" onclick="sendAjax(\'delete-' + type + '-property\', ' + id + ')">' +
        '<svg viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" /></svg></div>' +
        '<div class="shop_product_' + type + '_property_icon_edit" onclick="changePropertyField(' + id + ', \'' + type + '\')">' +
        '<svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" /></svg></div>' +
        '<div class="shop_product_property_icon shop_product_gradient_' + serverId + '">' + svg + '</div>' +
        '<div class="shop_product_property_title">' + title + '</div>' +
        '</form>';
    return result;
}

function changePropertyField(id, type = 'table') {
    let title = $('#edit-' + type + '-property_' + id).children('.shop_product_property_title').text();
    let checked = $('#edit-' + type + '-property_' + id).hasClass('shop_product_property_disabled') ? '' : 'checked';
    let sort = $('#edit-' + type + '-property_' + id).attr('data-sort');
    let elements =
        '<div class="shop_product_' + type + '_property_icon_delete" onclick="sendAjax(\'delete-' + type + '-property\', ' + id + ')">' +
        '<svg viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" /></svg></div>' +
        '<div class="shop_product_' + type + '_property_icon_edit" onclick="sendAjax(\'edit-' + type + '-property_' + id + '\', ' + id + ')">' +
        '<svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" /></svg></div>' +
        '<div class="shop_sort_property"><input class="shop_sort" type="number" name="sort" min="1" value="' + sort + '"/></div>' +
        '<input name="active" class="shop_property_checkbox" type="checkbox" ' + checked + '>' +
        '<input name="title" class="shop_property_input" type="text" value="' + title + '">';
    $('#edit-' + type + '-property_' + id).empty();
    $('#edit-' + type + '-property_' + id).html(elements);
}

function changePropertyFieldDone(id, serverId, type = 'table') {
    let parent = $('#edit-' + type + '-property_' + id);
    let title = parent.children(".shop_property_input").val();
    let active = parent.children(".shop_property_checkbox").is(":checked");
    let svg = active == 1 ? '<svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve"><g><path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path></g></svg>' : '<svg class="property_icon_dsb" x="0" y="0" viewBox="0 0 174.239 174.239" xml:space="preserve"><g><path d="M146.537 1.047a3.6 3.6 0 0 0-5.077 0L89.658 52.849a3.6 3.6 0 0 1-5.077 0L32.78 1.047a3.6 3.6 0 0 0-5.077 0L1.047 27.702a3.6 3.6 0 0 0 0 5.077l51.802 51.802a3.6 3.6 0 0 1 0 5.077L1.047 141.46a3.6 3.6 0 0 0 0 5.077l26.655 26.655a3.6 3.6 0 0 0 5.077 0l51.802-51.802a3.6 3.6 0 0 1 5.077 0l51.801 51.801a3.6 3.6 0 0 0 5.077 0l26.655-26.655a3.6 3.6 0 0 0 0-5.077L121.39 89.658a3.6 3.6 0 0 1 0-5.077l51.801-51.801a3.6 3.6 0 0 0 0-5.077L146.537 1.047z"></path></g></svg>';
    let sort = parent.find(".shop_sort").val();
    if (parent.hasClass('shop_product_property_disabled') && active) {
        parent.removeClass('shop_product_property_disabled');
    } else if (!parent.hasClass('shop_product_property_disabled') && !active) {
        parent.addClass('shop_product_property_disabled');
    }
    parent.attr('data-sort', sort);
    let elements =
        '<div class="shop_delete_server shop_product_price_delete" onclick="sendAjax(\'delete-' + type + '-property\', ' + id + ')">' +
        '<svg viewBox="0 0 320 512"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path></svg></div>' +
        '<div class="shop_edit_server shop_product_price_edit" onclick="changePropertyField(' + id + ', \'' + type + '\')">' +
        '<svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path></svg></div>' +
        '<div class="shop_sort_property"><input type="number" name="sort" min="1" value="' + sort + '" readonly/></div>' +
        '<div class="shop_product_property_icon shop_product_gradient_' + serverId + '">'+svg+'</div>' +
        '<div class="shop_product_property_title">' + title + '</div>';
    $('#edit-' + type + '-property_' + id).empty();
    $('#edit-' + type + '-property_' + id).html(elements);
}
var countCreateTableProperty = 0;

function createPropertyFields(serverId, type = "table") {
    let property =
        '<form id="create-' + type + '-property_' + countCreateTableProperty + '"' +
        'class="shop_product_property shop_table_property">' +
        '<div class="shop_delete_server shop_product_price_delete" onclick="deleteCreatePropertyFields(' + countCreateTableProperty + ', \'' + type + '\')">' +
        '<svg viewBox="0 0 320 512"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path></svg></div>' +
        '<div class="shop_edit_server shop_product_price_edit"' +
        'onclick="sendAjax(\'create-' + type + '-property_' + countCreateTableProperty + '\', ' + serverId + ')">' +
        '<svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path></svg></div>' +
        '<div class="shop_sort_property"><input class="shop_sort" type="number" name="sort" min="1" value="1"/></div>' +
        '<input name="active" class="shop_property_checkbox" type="checkbox">' +
        '<input name="title" class="shop_property_input" type="text">' +
        '</form>';
    if (type == 'table') {
        $('.shop_' + type + '_fix').before(property);
    } else {
        $('.shop_' + type + '_fix_' + serverId).before(property);
    }
    countCreateTableProperty += 1;
    let propsElement = document.querySelector('.props');
    if (propsElement) {
        propsElement.scrollTop = propsElement.scrollHeight;
    }
}

function deleteCreatePropertyFields(id, type = 'table') {
    $('#create-' + type + '-property_' + id).remove();
}

function editServerTableInfo(data) {
    $(".shop_table_edit_server").attr("data-value", data.id);
    $("#shop_server_edit_name").val(data.name);
    $("#shop_server_edit_id").val(data.iks_id);
    if ($("#web_server_id_" + data.web_server_id).length) {
        $("#edit_web_server_id").val(data.web_server_id);
    } else {
        $("#web_server_id_none").prop("selected", true);
    }
}

function editPromoTableInfo(data) {
    $("#edit_name_promo").val(data.name);
    $("#edit_percent_promo").val(data.percent);
    $("#edit_amount_promo").val(data.amount);
    $(".shop_edit_promo").attr("data-value", data.id);
}

function editCategoryTableInfo(data) {
    $("#edit_name_cat").val(data.name);
    $("#edit_sort_cat").val(data.sort);
    $(".shop_edit_cat").attr("data-value", data.id);
}

const mapType = new Map([
    ['vip_riko', '1'],
    ['vip_ws', '1'],
    ['vip_wcs', '1'],
    ['wcs_race', '1'],
    ['ma', '2'],
    ['iks', '6'],
    ['iks_vip', '6'],
    ['adminsystem', '6'],
    ['shop_credits', '3'],
    ['lr_exp', '3'],
    ['rcon', '4'],
    ['wcs_level', '3'],
    ['wcs_gold', '3']
]);

$(document).on('click', '.shop_black_screen', function () {
    $(".shop_black_screen").fadeOut();
    $(".shop_table").fadeOut();
    $(".wrapper_server_accept").fadeOut();
    $("#properties_table").fadeOut().removeClass("active");
});

$(document).ready(function () {
    $("#properties_table").on('transitionend', function (e) {
        if (!$(this).hasClass("active")) {
            $("html").css({
                "overflow": "auto"
            });
        }
    });
});

function openPropertyTable() {
    $(".shop_black_screen").fadeIn();
    $("#properties_table").fadeIn().addClass("active");
    $("html").css({
        "overflow": "hidden"
    });
}

function closePropertyTable() {
    $(".shop_black_screen").fadeOut();
    $("#properties_table").fadeOut().removeClass("active");
}

function removeTableProperty(id, type = 'table') {
    $('#edit-' + type + '-property_' + id).remove();
}

function setPrice(serverId, id) {
    $('#input_price_' + serverId).val(id);
    let priceTitle = $('#option_price_' + serverId + '_' + id).children('.shop_price_title').html();
    let priceTitleValue = $('#option_price_' + serverId + '_' + id).children('.shop_price_title_value').html();
    $('#select_title_' + serverId).html(priceTitle + priceTitleValue);
    let price = $('#option_price_' + serverId + '_' + id).data("price");
    let price_old = $('#option_price_' + serverId + '_' + id).data("price_old");
    let value = $('#option_price_' + serverId + '_' + id).data("value");

    $('#shop_product_description_price_' + serverId).children('.shop_product_color_value_' + serverId).text(price + value);
    $('#shop_product_price_' + serverId).children('.shop_product_price_count').text(price);
    if (price != price_old) {
        $('#shop_product_price_' + serverId).children('.shop_product_price_old').text(price_old);
    }
    $('#shop_product_price_' + serverId).children('.shop_product_color_value_' + serverId).text(value);
}

function togglePrice(id) {
    let status = $('#select_price_title_' + id).data('value');
    let display = status === 0 ? 'block' : 'none';

    $('#select_price_title_' + id).data('value', status === 0 ? 1 : 0);

    $('#select_price_' + id).stop(true, true).fadeToggle(300, function () {
        if ($('#select_price_' + id).is(':visible')) {
            $("#select_price_icon_" + id).css({ transform: 'rotateX(0deg)' });
            $("#select_price_icon_" + id).animate({ deg: 180 }, {
                duration: 300,
                step: function (now) {
                    $("#select_price_icon_" + id).css({ transform: 'rotateX(' + now + 'deg)' });
                }
            });
        } else {
            $("#select_price_icon_" + id).css({ transform: 'rotateX(180deg)' });
            $("#select_price_icon_" + id).animate({ deg: 0 }, {
                duration: 300,
                step: function (now) {
                    $("#select_price_icon_" + id).css({ transform: 'rotateX(' + now + 'deg)' });
                }
            });
        }
    });
}

function showAddPriceTable(productId) {
    $('.shop_table_add_price').attr('data-value', productId);
    let type = mapType.get($('#shop_product_' + productId).attr('data-type'));
    $('#add-price-options').children('.shop_label_price').hide();
    $('#add-price-options').children('.shop_price_options').hide();
    $('#add-price-options').children('.shop_tx_0').show();
    $('#add-price-options').children('.shop_tx_' + type).show();
    showShopTable('shop_table_add_price');
}

function viewAdminPoints(id) {
    $('.view-shop').fadeOut();
    $('.view-shop-' + id).css("display", "block");
}

function showShopTable(id) {
    $(".shop_black_screen").fadeIn();
    $("." + id).fadeIn();
}

function hideShopTable(id) {
    $("." + id).fadeOut();
    $(".shop_black_screen").fadeOut();
}

function showCatalog(id) {
    server = id;
    $('.shop_product_wrapper').hide();
    $('.shop_product_server_' + id).fadeIn();
    $(".shop_server_active").removeClass("shop_server_active");
    let serverText = $('.shop_server_' + id).text();
    document.getElementById('name_server').textContent = serverText;
    $(".shop_server_" + id).addClass("shop_server_active");
    $(".wrapper_server_accept").hide();
    $(".shop_black_screen").hide();
    $(".shop_cat_active").removeClass("shop_cat_active");
    $(".shop_cat_0").addClass("shop_cat_active");
}
function showCategory(id) {
    $('.shop_product_wrapper.shop_product_server_' + server).hide();
    if (id > 0) {
        $('.shop_product_cat_' + id + '.shop_product_server_' + server).fadeIn();
    } else {
        $('.shop_product_server_' + server).fadeIn();
    }
    $(".shop_cat_active").removeClass("shop_cat_active");
    $(".shop_cat_" + id).addClass("shop_cat_active");
}

function changePayment(paymentId, payment) {
    $('#payment').attr('value', paymentId);
    $(".payment").css({
        border: "1px solid var(--button-color-hover)",
        color: "var(--default-text-color)"
    });
    $(payment).css(
        'background', "var(--button-color-hover)",
        'border', "1px solid var(--button-color-hover)",
        'color', "var(--default-text-color)"
    );
}

document.addEventListener("DOMContentLoaded", function () {
    const uniqueToggleSwitch = document.querySelector(".unique-toggle-switch");
    const uniqueSlider = document.querySelector(".unique-slider");
    const uniqueToggleInput = document.querySelector(".unique-toggle-input");
    const uniqueToggleInputContainer = document.querySelector(".unique-toggle-input-container");
    const uniqueToggleOptions = document.querySelectorAll(".unique-toggle-option");
    const defaultOption = document.querySelector('.unique-toggle-option[data-value="for-self"]');

    if (uniqueSlider && uniqueToggleInput && uniqueToggleInputContainer) {
        const defaultOffset = defaultOption.offsetLeft;

        uniqueSlider.style.left = defaultOffset + "px";
        uniqueToggleInput.style.opacity = 0;
        uniqueToggleInputContainer.style.height = "0";
        defaultOption.classList.add("active");

        uniqueToggleOptions.forEach((option) => {
            const value = option.getAttribute("data-value");
            option.style.color = option.classList.contains("active")
                ? value === "as-gift"
                    ? "var(--money)"
                    : "var(--span)"
                : "var(--text-custom)";
        });

        uniqueToggleSwitch.addEventListener("click", function (e) {
            const clickedOption = e.target.closest(".unique-toggle-option");
            if (!clickedOption) return;

            const value = clickedOption.getAttribute("data-value");
            const offset = clickedOption.offsetLeft;

            uniqueSlider.style.left = offset + "px";
            uniqueToggleInput.style.opacity = value === "as-gift" ? 1 : 0;
            uniqueToggleInputContainer.style.height =
                value === "as-gift" ? "auto" : "0";
            uniqueSlider.classList.toggle("as-gift", value === "as-gift");

            localStorage.setItem("selectedOption", value);

            uniqueToggleOptions.forEach((option) => {
                const optionValue = option.getAttribute("data-value");
                option.style.color =
                    option === clickedOption
                        ? value === "as-gift"
                            ? "var(--money)"
                            : "var(--span)"
                        : "var(--text-custom)";
            });

            uniqueToggleInput.classList.toggle("hidden_gift", value !== "as-gift");
        });
    }
});

$(document).on("mouseover", ".back_video", function () {
    $(this).get(0).play();
});
$(document).on("mouseout", ".back_video", function () {
    $(this).get(0).pause();
});