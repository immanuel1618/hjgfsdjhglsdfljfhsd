<div class="shop_table shop_table_add_card" style="display: none;">
    <div class="shop_header_table">
        <?= $Translate->get_translate_module_phrase('module_page_store', '_addingProduct') ?>
    </div>
    <div class="shop_body_table shop_card_add_edit">
        <form id="add-product" class="input-form">
            <div class="input-form">
                <input type="checkbox" name="status" class="border-checkbox" id="status" checked>
                <label for="status" class="border-checkbox-label">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_status') ?>
                </label>
            </div>
            <label for="type_card" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_takeTypeOfProduct') ?>
            </label>
            <select name="type" id="type_card" class="shop_list_servers">
                <option value="vip_riko">VIP by Pisex/thesamefabius/Riko</option>
                <option value="iks_vip">IksAdmin && VIP by Pisex/thesamefabius/Riko</option>
                <option value="ma">MaterialAdmin</option>
                <option value="iks">IksAdmin</option>
                <option value="adminsystem">AdminSystem</option>
                <option value="vip_ws">WS VIP</option>
                <option value="shop_credits">SHOP Credits</option>
                <option value="lr_exp">LR Expirience</option>
                <option value="rcon">RCON Command</option>
                <option value="wcs_level">WCS Levels</option>
                <option value="wcs_gold">WCS Gold</option>
                <option value="wcs_race">WCS Private Races</option>
                <option value="vip_wcs">WCS VIP</option>
            </select>
            <label for="title" class="shop_label_product">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_titleOfProduct') ?>:
            </label>
            <input type="text" class="shop_input_product" id="title" name="title">
            <label for="sort" class="shop_label_product">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_sortOfProduct') ?>:
            </label>
            <input type="text" class="shop_input_product" id="sort" name="sort">
            <div class="input-form">
                <input type="checkbox" name="title_show" class="border-checkbox" id="title_show" checked>
                <label for="title_show" class="border-checkbox-label">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_title_show') ?>
                </label>
            </div>
            <label for="category" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_takeCatOfProduct') ?>
            </label>
            <select name="category" id="category" class="shop_list_servers">
                <option value="0">Отсутствует</option>
                <?php foreach($categories as $cat):?>
                    <option value="<?= $cat['id']?>"><?= $cat['name']?></option>
                <?php endforeach;?>
            </select>
            <label for="badge" class="shop_label_product">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_badgeOfProduct') ?>:
            </label>
            <input type="text" class="shop_input_product" id="badge" name="badge">
            <label for="discount" class="shop_label_product">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_discountForProduct') ?><br>
            </label>
            <input type="text" class="shop_input_product" value="0" id="discount" name="discount">
            <input type="checkbox" name="table_status" class="border-checkbox" id="table_status" checked>
            <label for="table_status" class="border-checkbox-label">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_tableStatus') ?>
            </label>
            <label class="shop_label_product" for="color">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_startOfGradient') ?>:
            </label>
            <input name="color" class="color_input" id="color" class="gradient_input" value="#5865F2" data-jscolor="{value: '#5865F2'}">
            <label class="shop_label_product" for="img">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_img_link') ?>:
            </label>
            <input name="img" class="shop_input_product" id="img" value="">
            <div class="shop_wrapper_table_button">
                <div class="shop_button_add_server" onclick="sendAjax('add-product', $('.shop_server_active').attr('data-value'))">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_addProduct') ?>
                </div>
                <div class="shop_button_cancel" onclick="hideShopTable('shop_table_add_card')">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_cancel') ?>
                </div>
            </div>
        </form>
        <div class="shop_wrapper_product hide_example" style="width: 650px;">
            <label class="shop_label_product"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopExmpls') ?></label>
            <div class="shop_card_wrapper">
                <div class="shop_product">
                <div class="shop_badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopNewBadge') ?></div>
                    <div class="shop_header">
                        <img class="shop_product_img" src="<?= $General->arr_general['site'] . 'app/modules/module_page_store/assets/img/example.png' ?>" alt="">
                        <div class="shop_product_title">
                            <p class="shop_gradient_test shop_product_gradient_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_titleOfProduct') ?></p>
                        </div>
                    </div>
                    <div class="shop_product_select_title">
                        <div class="shop_product_select_title_text">
                            30 <?= $Translate->get_translate_module_phrase('module_page_store', '_days') ?> -
                            <span class="shop_gradient_test">1000 <?= $options['amount_value'] ?></span>
                        </div>
                        <div class="shop_product_select_button">
                            <svg viewBox="0 0 448 512">
                                <path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                            </svg>
                        </div>
                    </div>
                    <center>
                        <div class="shop_product_description">
                            <?= $Translate->get_translate_module_phrase('module_page_store', '_productAdvantages') ?>
                            <div data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_allAdvantages') ?>" data-tippy-placement="top" class="shop_product_button_info">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_shopShowAll') ?>
                            </div>
                        </div>
                    </center>
                    <div class="shop_product_properties no-scrollbar">
                        <div class="shop_product_property">
                            <div class="shop_product_property_icon shop_gradient_test_icon">
                                <svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve">
                                    <g>
                                        <path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="shop_product_property_title "><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPropertys') ?> 1</div>
                        </div>
                        <div class="shop_product_property">
                            <div class="shop_product_property_icon shop_gradient_test_icon">
                                <svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve">
                                    <g>
                                        <path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="shop_product_property_title "><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPropertys') ?> 2</div>
                        </div>
                        <div class="shop_product_property">
                            <div class="shop_product_property_icon shop_gradient_test_icon">
                                <svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve">
                                    <g>
                                        <path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="shop_product_property_title "><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPropertys') ?> 3</div>
                        </div>
                        <div class="shop_product_property">
                            <div class="shop_product_property_icon shop_gradient_test_icon">
                                <svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve">
                                    <g>
                                        <path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="shop_product_property_title "><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPropertys') ?> 4</div>
                        </div>
                    </div>
                    <div class="shop_flex_row">
                        <div class="shop_buy_price">
                            <div class="shop_product_description_price">
                                <div class="shop_product_price">
                                    <span class="shop_product_price_count">800</span>
                                    <span class="shop_product_price_value"><?= $options['amount_value'] ?></span>
                                    <span class="shop_product_price_old">1000 <?= $options['amount_value'] ?></span>
                                </div>
                            </div>
                            <div class="shop_discount_icon">
                                - 20 %
                            </div>
                        </div>
                        <div class="shop_product_button shop_gradient_test_button">
                            <svg viewBox="0 0 576 512">
                                <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20h44v44c0 11 9 20 20 20s20-9 20-20V180h44c11 0 20-9 20-20s-9-20-20-20H356V96c0-11-9-20-20-20s-20 9-20 20v44H272c-11 0-20 9-20 20z"></path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_store', '_addBasket') ?>
                        </div>
                    </div>
                    <?php require MODULES . "module_page_store/includes/styles/product_style.php" ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= $General->arr_general['site'] . '/' . MODULES ?>module_page_store/assets/js/jscolor.min.js"></script>
<script>
    jscolor.presets.default = {
        alphaChannel: false,
        position: 'top',
        format: 'hex',
        zIndex: 31000,
        previewPosition: 'right',
        backgroundColor: 'var(<?= ($General->arr_general['theme'] == "neo") ? "--bg" : "--bg-color";?>)',
        borderColor: 'var(--bottom-line-table)',
        borderRadius: 16,
        controlBorderColor: 'var(--bottom-line-table)',
        height: 150,
        width: 300,
        padding: 20,
        onInput: function() {
            let startAdd = $('.color_input').attr('data-current-color');
            let startEdit = $('.color_input_edit').attr('data-current-color');

            $('.color_input').attr('value', startAdd);
            $('.color_input_edit').attr('value', startEdit);

            $('.shop_gradient_test')
                .css("background", startAdd)
                .css("-webkit-background-clip", "text");

            $('.shop_gradient_test_edit')
                .css("background", startEdit)
                .css("-webkit-background-clip", "text");

            $('.shop_gradient_test_edit_button')
                .css("background", startEdit)

            $('.shop_gradient_test_edit_icon')
                .css("fill", startEdit)

            $('.shop_gradient_test_button')
                .css("background", startAdd)

            $('.shop_gradient_test_icon')
                .css("fill", startAdd)
        },
    }
</script>