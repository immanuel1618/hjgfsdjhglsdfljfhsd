<div class="shop_table shop_table_edit_server" style="display: none" data-value="0">
    <div class="shop_header_table">
        <?= $Translate->get_translate_module_phrase( 'module_page_store','_editServerInfo')?>
    </div>
    <div class="shop_body_table">
        <form id="edit-server" class="input-form">
            <label for="edit_web_server_id" class="shop_label_list_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_takeShopServer')?>
            </label>
            <select name="web_server_id" id="edit_web_server_id" class="shop_list_servers" placeholder="-">
                <?php foreach($serversLR as $server):?>
                    <option id="web_server_id_none" style="display:none">
                        <?php echo $Translate->get_translate_module_phrase( 'module_page_shop','_errorServerFind')?>
                    </option>
                    <option class="web_server_id_<?= $server['id']?>" id="web_server_id_<?= $server['id']?>" value="<?= $server['id']?>">
                        <?= $server['name']?>
                    </option>
                <?php endforeach?>
            </select>
            <label for="shop_server_edit_name" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_displayingShopName')?>
            </label>
            <input type="text" id="shop_server_edit_name" name="name">
            <label for="shop_server_edit_id" class="shop_label_name_server">
                <?= $Translate->get_translate_module_phrase( 'module_page_store','_displayingShopIKSId')?>
            </label>
            <input type="text" id="shop_server_edit_id" name="iks_id">
            <div class="shop_wrapper_table_button">
                <div class="shop_button_add_server" id="edit_server_button" onclick="sendAjax('edit-server', $('.shop_table_edit_server').attr('data-value'))">
                    <?= $Translate->get_translate_module_phrase( 'module_page_store','_editServer')?>
                </div>
                <div class="shop_button_cancel" onclick="hideShopTable('shop_table_edit_server')">
                    <?= $Translate->get_translate_module_phrase( 'module_page_store','_cancel')?>
                </div>
            </div>
        </form>
    </div>
</div>