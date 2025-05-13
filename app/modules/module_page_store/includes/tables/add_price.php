<div class="shop_table shop_table_add_price" data-value="0" style="display: none">
    <div class="shop_header_table">
        <?= $Translate->get_translate_module_phrase('module_page_store', '_addPrice') ?>
    </div>
    <div class="shop_body_table">
        <form id="add-price-options" class="input-form">
            <label for="shop_price_input" class="shop_label_price shop_tx_0">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterPrice') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_0" id="shop_price_input" name="price">

            <!-- Количество -->
            <label for="shop_add_price_amount" class="shop_label_price shop_tx_3">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterAmount') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_3" id="shop_add_price_amount" name="amount">

            <!-- Название группы -->
            <label for="shop_add_price_group" class="shop_label_price shop_tx_1 shop_tx_2 shop_tx_6">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterGroup') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_1 shop_tx_2 shop_tx_6" id="shop_add_price_group" name="group">

            <!-- Валюта количества -->
            <label for="shop_add_price_race" class="shop_label_price shop_tx_3">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterAmountValue') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_3" id="shop_add_price_race" name="amount_value">

            <!-- Rcon -->
            <label for="shop_add_price_rcon" class="shop_label_price rconinfo shop_tx_4">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterRcon') ?>
                <div data-openmodal="modal_rcon" class="shop_rconinfo">
                    ?
                </div>
            </label>
            <input type="text" class="shop_price_options shop_tx_4" id="shop_add_price_rcon" name="rcon">

            <div class="input-form shop_label_price shop_tx_4">
                <input type="checkbox" name="all_servers" class="border-checkbox" id="all_servers">
                <label for="all_servers" class="border-checkbox-label"><?= $Translate->get_translate_module_phrase('module_page_store', '_RconAllServers') ?></label>
            </div>

            <!-- Rcon название при покупке -->
            <label for="shop_add_price_rcon_name" class="shop_label_price shop_tx_4">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterRconTitle') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_4" id="shop_add_price_rcon_name" name="title">

            <!-- ID WEB группы-->
            <label for="shop_add_price_web_group" class="shop_label_price shop_tx_2">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterWebGroupId') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_2" value="-1" id="shop_add_price_web_group" name="web_group_id">

            <!-- Время -->
            <label for="shop_add_price_time" class="shop_label_price shop_tx_1 shop_tx_2 shop_tx_5 shop_tx_6">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterTime') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_1 shop_tx_2 shop_tx_5 shop_tx_6" id="shop_add_price_time" name="time">

            <!-- Отображаемое время -->
            <label for="shop_add_price_time_value" class="shop_label_price shop_tx_1 shop_tx_2 shop_tx_5 shop_tx_6">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_enterTimeValue') ?>
            </label>
            <input type="text" class="shop_price_options shop_tx_1 shop_tx_2 shop_tx_5 shop_tx_6" id="shop_add_price_time_value" name="time_value">

            <div class="shop_wrapper_table_button shop_table_price_buttons">
                <div class="shop_button_add_server"
                    onclick="sendAjax('add-price-options', $('.shop_table_add_price').attr('data-value'))">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_add') ?>
                </div>
                <div class="shop_button_cancel" onclick="hideShopTable('shop_table_add_price')">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_cancel') ?>
                </div>
            </div>
        </form>
    </div>
    <div class="popup_modal" id="modal_rcon">
        <div class="popup_modal_content no-close no-scrollbar">
            <div class="popup_modal_head">
                Rcon Info
                <span class="popup_modal_close">
                    <svg viewBox="0 0 320 512">
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                    </svg>
                </span>
            </div>
            <div class="accept_content">
                <span><a>%n</a> = name</span>
                <span><a>%s0</a> = STEAM_0:xxxxxxxx</span>
                <span><a>%s1</a> = STEAM_1:xxxxxxxx</span>
                <span><a>%s3</a> = STEAM 3 or accountid</span>
                <span><a>%s64</a> = STEAM 64</span>
            </div>
            <div class="shop_accetp_buttons">
                <div class="secondary_btn btn_delete popup_modal_close"><?= $Translate->get_translate_module_phrase('module_page_store', '_cancel') ?></div>
            </div>
        </div>
    </div>
</div>