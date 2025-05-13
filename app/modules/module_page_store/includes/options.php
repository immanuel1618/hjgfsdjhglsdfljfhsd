<?php
if (isset($_SESSION['user_admin'])) :
    $promocodes = $Promocode->getAll();
    $categories = $Category->getAllSorted();
    $globalDiscount = $discounts[-1];
?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_Category_shop') ?></h5>
            </div>
            <div style="padding:10px 15px 0px">
                <?php foreach ($categories as $cat) : ?>
                    <div class="promo_line">
                        <div class="promo_left">
                            <div class="promo_text">
                                <div class="promo_name">
                                    <?= $Translate->get_translate_module_phrase('module_page_store', '_name') ?>:
                                    <?= $cat['name']; ?>
                                </div>
                                <div class="promo_badges">
                                    <div class="promo_badge amount_badge">
                                        <?= $Translate->get_translate_module_phrase('module_page_store', '_sort') ?>:
                                        <?= $cat['sort']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="promo_action">
                            <div class="promo_action_edit" onclick="sendAjax('edit-ajax-cat', '<?= $cat['id'] ?>')">
                                <svg viewBox="0 0 512 512">
                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path>
                                </svg>
                            </div>
                            <div class="promo_action_delete" onclick="sendAjax('delete-cat', '<?= $cat['id'] ?>')">
                                <svg viewBox="0 0 320 512">
                                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="card-container">
                <div class="secondary_btn" onclick="showShopTable('shop_add_cat')">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_createCategory') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_options_shop') ?></h5>
            </div>
            <div class="card-container settings_options">
                <div class="shop_inputs">
                    <div class="shop_input">
                        <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_discount') ?></div>
                        <form id="discount" class="input-form">
                            <label for="value_discount" class="shop_label_list_server">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_percentOfDiscountByAllProducts') ?>:
                            </label>
                            <input type="text" id="value_discount" name="value" value="<?= $globalDiscount ?>" class="input_promo">
                            <div class="secondary_btn" onclick="sendAjax('discount', '-1')">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_updateDiscount') ?>
                            </div>
                        </form>
                    </div>
                    <div class="shop_input">
                        <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_amountValue') ?></div>
                        <form id="amount-value" class="input-form">
                            <label for="amount_value" class="shop_label_list_server">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_amountValue') ?>:
                            </label>
                            <input type="text" id="amount_value" name="amount_value" value="<?= $options['amount_value'] ?? '' ?>" class="input_promo">
                            <div class="secondary_btn dd_promo add_discount" onclick="sendAjax('amount-value', '-1')">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_updateValue') ?>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="shop_inputs">
                    <div class="shop_input">
                        <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_adminMode') ?></div>
                        <form id="only-admin" class="input-form">
                            <input type="checkbox" onclick="sendAjax('only-admin', '-1')" name="only_for_admin" id="only_for_admin" class="border-checkbox" <?= $options['only_for_admin'] ? 'checked' : ''; ?>>
                            <label for="only_for_admin" class="border-checkbox-label">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_includeAdminMode') ?>
                            </label>
                        </form>
                    </div>
                    <div class="shop_input">
                        <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_serverAccept') ?></div>
                        <form id="use-server-accept" class="input-form">
                            <input type="checkbox" onclick="sendAjax('use-server-accept', '-1')" name="use_server_accept" id="use_server_accept" class="border-checkbox" <?= $options['use_server_accept'] ? 'checked' : ''; ?>>
                            <label for="use_server_accept" class="border-checkbox-label">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_useServerAccept') ?>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="shop_inputs">
                    <div class="shop_input">
                        <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_Product_cards') ?></div>
                        <form id="extend-cards" class="input-form">
                            <input type="checkbox" onclick="sendAjax('extend-cards', '-1')" name="extend_cards" id="extend_cards" class="border-checkbox" <?= $options['extend_cards'] ? 'checked' : ''; ?>>
                            <label for="extend_cards" class="border-checkbox-label">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_Extend_product_cards') ?>
                            </label>
                        </form>
                    </div>
                    <div class="shop_input">
                    </div>

                </div>
                <hr>
                <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_webhook') ?></div>
                <form id="discord-webhook" class="input-form">
                    <label for="discord_webhook" class="shop_label_list_server">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_discordWebhook') ?>:
                    </label>
                    <input type="text" id="discord_webhook" name="discord_webhook" value="<?= $options['discord_webhook'] ?>" class="input_promo">
                    <div class="shop_inputs">
                        <div class="shop_input">
                            <label for="discord_webhook" class="shop_label_list_server">
                                <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopEmbedColor') ?></div>
                            </label>
                            <input type="text" id="discord_webhook" name="hexcolor_wehbook" value="<?= $options['hexcolor_wehbook'] ?>" class="input_promo" data-jscolor="{value: '<?= $options['hexcolor_wehbook'] ?>', backgroundColor: 'var(--bg)', borderColor: 'var(--bottom-line-table)', borderRadius: 16, controlBorderColor:'var(--bottom-line-table)', height: 150, width: 300, padding: 20}">
                        </div>
                        <div class="shop_input">
                            <label for="discord_webhook" class="shop_label_list_server">
                                <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopImgLink') ?></div>
                            </label>
                            <input type="text" id="discord_webhook" name="img_webhook" value="<?= $options['img_webhook'] ?>" class="input_promo">
                        </div>
                    </div>
                    <div class="secondary_btn add_promo add_discount" onclick="sendAjax('discord-webhook', '-1')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_setWebhook') ?>
                    </div>
                </form>
                <hr>
                <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_vkmessage') ?></div>
                <form id="vk-message" class="input-form">
                    <label for="vk_apikey" class="shop_label_list_server">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_vk_apikey') ?>:
                    </label>
                    <input type="text" id="vk_apikey" name="vk_apikey" value="<?= $options['vk_apikey'] ?>" class="input_promo">
                    <label for="vk_peer_id" class="shop_label_list_server">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_vk_peer_id') ?>:
                    </label>
                    <input type="text" id="vk_peer_id" name="vk_peer_id" value="<?= $options['vk_peer_id'] ?>" class="input_promo">
                    <div class="secondary_btn add_promo add_discount" onclick="sendAjax('vk-message', '-1')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_setvkmessage') ?>
                    </div>
                </form>
                <hr>
                <div class="h3_shop"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopHowMuchCocks') ?></div>
                <form id="change-column-count">
                    <input type="radio" name="column_count" onclick="sendAjax('change-column-count', '3')" id="column-count-3" value="3" <?= $options['column_count'] === '3' ? 'checked' : '' ?>>
                    <label for="column-count-3" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_store', '_shop3columns') ?></label>
                    <input type="radio" name="column_count" onclick="sendAjax('change-column-count', '4')" id="column-count-4" value="4" <?= $options['column_count'] === '4' ? 'checked' : '' ?>>
                    <label for="column-count-4" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_store', '_shop4columns') ?></label>
                </form>
            </div>
        </div>
    </div>
    <div class="shop_table shop_add_cat" style="display: none">
        <div class="shop_header_table">
            <?= $Translate->get_translate_module_phrase('module_page_store', '_creatingCategory') ?>
        </div>
        <div class="shop_body_table">
            <form id="add-cat" class="input-form">
                <label for="name_cat" class="shop_label_list_server">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_name') ?>:
                </label>
                <input type="text" id="name_cat" name="name" class="input_cat">
                <label for="value_cat" class="shop_label_list_server">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_sort') ?>:
                </label>
                <input type="text" id="value_cat" name="sort" class="input_cat">
                <div class="shop_wrapper_table_button">
                    <div class="shop_button_add_server" onclick="sendAjax('add-cat', '')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_createCategory') ?>
                    </div>
                    <div class="shop_button_cancel" onclick="hideShopTable('shop_add_cat')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="shop_table shop_edit_cat" data-value="0" style="display: none">
        <div class="shop_header_table">
            <?= $Translate->get_translate_module_phrase('module_page_store', '_updatingCategory') ?>
        </div>
        <div class="shop_body_table">
            <form id="edit-cat" class="input-form">
                <label for="edit_name_cat" class="shop_label_list_server">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_name') ?>:
                </label>
                <input type="text" id="edit_name_cat" name="name" class="input_cat">
                <label for="edit_sort_cat" class="shop_label_list_server">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_sort') ?>:
                </label>
                <input type="text" id="edit_sort_cat" name="sort" class="input_cat">
                <div class="shop_wrapper_table_button">
                    <div class="shop_button_add_server" onclick="sendAjax('edit-cat', $('.shop_edit_cat').attr('data-value'))">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_updateCategory') ?>
                    </div>
                    <div class="shop_button_cancel" onclick="hideShopTable('shop_edit_cat')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="shop_black_screen" style="display: none"></div>
<?php endif; ?>
<script src="<?= $General->arr_general['site'] . '/' . MODULES ?>module_page_store/assets/js/jscolor.min.js"></script>
<script>
    jscolor.presets.default = {
        alphaChannel: false,
        position: 'top',
        format: 'hex',
        zIndex: 31000,
        previewPosition: 'right',
        onInput: function() {
            var startAdd = $('.color_input').attr('data-current-color');

            $('.color_input').attr('value', startAdd);

            $('.shop_product_gradient_test').css("background", startAdd);
        },
    }
</script>