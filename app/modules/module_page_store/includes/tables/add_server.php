<div class="shop_table shop_table_add_server" style="display: none">
    <div class="shop_header_table">
        <?= $Translate->get_translate_module_phrase( 'module_page_store','_addServer')?>
    </div>
    <div class="shop_body_table">
        <form id="add-server" class="input-form">
            <label for="shop_list_servers" class="shop_label_list_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_takeShopServer')?>
            </label>
            <select name="web_server_id" id="shop_list_servers" class="custom-select" placeholder="<?= $Translate->get_translate_module_phrase( 'module_page_store','_takeShopServer')?>">
                <?php foreach($serversLR as $server):?>
                    <option id="<?= $server['id']?>" value="<?= $server['id']?>"><?= $server['name']?></option>
                <?php endforeach?>
            </select>
            <label for="shop_name_server" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_displayingShopName')?>
            </label>
            <input type="text" id="shop_server_name" name="name">
            <label for="shop_iks_id_server" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_displayingShopIKSId')?>
            </label>
            <input type="text" id="shop_iks_id_server" name="iks_id">
            <div class="shop_wrapper_table_button">
                <div class="shop_button_add_server" onclick="sendAjax('add-server', '')">
                    <?= $Translate->get_translate_module_phrase( 'module_page_store','_addingServer')?>
                </div>
                <div class="shop_button_cancel" onclick="hideShopTable('shop_table_add_server')">
                    <?= $Translate->get_translate_module_phrase( 'module_page_store','_cancel')?>
                </div>
            </div>
        </form>
    </div>
</div>