<?php !isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') && die();
foreach ($Db->db_data as $mod) :
    foreach ($mod as $connection) :
        $db_data[] = $connection;
    endforeach;
endforeach;
$db_data_file = require SESSIONS . '/db.php';
$edit_info = explode(";", $_GET['data']);
?>

<div id="add_connect" class="modal-window server_form">
    <div class="card">
        <div class="card-header pb0">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Add_con') ?></div>
            <div class="new_connect" id="con_mod_name"></div>
            <a href="#" title="Закрыть" class="modal-close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </a>
        </div>
        <form enctype="multipart/form-data" method="post" id="form-add-conection">
            <input type="hidden" id="con_mod_id" name="mod">
            <div class="input-form">
                <div class="wrapper-db-select" id="db_select_con" style="display:none">
                    <div class="input_text add_connection_label"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_take_db_con') ?></div>
                    <select style="display: none;" class="custom-select" name="db_name_for_table" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_non_take_con') ?>">
                        <?php foreach ($db_data_file as $mod_name => $mod) :
                            foreach ($mod as $connection) : ?>
                                <option style="display:none;" class="con_<?= $mod_name; ?>" value="<?= $connection['DB'][0]['DB']; ?>">
                                    <?= $connection['DB'][0]['DB']; ?>
                                </option>
                        <?php endforeach;
                        endforeach; ?>
                    </select>
                </div>
                <div id="db_option_con" class="wrapper_connection_option">
                    <div>
                        <label class="input_text add_connection_label" for="con_host"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_host') ?></label>
                        <input type="text" name="host" id="con_host">
                        <label class="input_text add_connection_label" for="con_db_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_name_db') ?></label>
                        <input type="text" name="db_name" id="con_db_name">
                        <label class="input_text add_connection_label" for="con_user_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_username') ?></label>
                        <input type="text" name="username" id="con_user_name">
                    </div>
                    <div>
                        <label class="input_text add_connection_label" for="con_password"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_password') ?></label>
                        <div class="wrapper-password">
                            <input type="password" name="password" id="con_password">
                            <div href="#" class="password-control" onclick="return show_hide_password(this);">
                                <svg viewBox="0 0 640 512">
                                    <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c5.2-11.8 8-24.8 8-38.5c0-53-43-96-96-96c-2.8 0-5.6 .1-8.4 .4c5.3 9.3 8.4 20.1 8.4 31.6c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zm223.1 298L373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5z" />
                                </svg>
                            </div>
                        </div>
                        <label class="input_text add_connection_label" for="con_port"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_port') ?></label>
                        <input type="text" name="port" id="con_port" value="3306">
                    </div>
                </div>
                <div class="wrapper_connection_option">
                    <div>
                        <div class="last_inputs">
                            <div>
                                <label class="input_text add_connection_label" for="con_table_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_table_name') ?></label>
                                <input type="text" id="con_table_name" name="table_name">
                            </div>
                            <div id="rank_pack_connection">
                                <label class="input_text add_connection_label" for="con_rank_pack"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_rank_pack') ?></label>
                                <input type="text" name="rank_pack" id="con_rank_pack" value="default">
                            </div>
                            <div>
                                <label class="input_text add_connection_label" for="con_server_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_name') ?></label>
                                <input type="text" name="server_name" id="con_server_name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="adm_save">
                <div class="secondary_btn w100 mt10" onclick="addConection()"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_add') ?></div>
            </div>
        </form>
    </div>
</div>
<div id="edit_connect" class="modal-window server_form">
    <div class="card">
        <div class="card-header pb0">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Edit_con') ?></div>
            <div class="new_connect"></div>
            <a href="#" title="Закрыть" class="modal-close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </a>
        </div>
        <form enctype="multipart/form-data" method="post" id="form-edit-conection">
            <input type="hidden" name="mod_edit" value="<?= $edit_info[0] ?>">
            <input type="hidden" name="mod_info_edit" value="<?= $_GET['data'] ?>">
            <div class="input-form">
                <div id="db_option_con" class="wrapper_connection_option">
                    <div>
                        <label class="input_text add_connection_label" for="con_host"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_host') ?></label>
                        <input type="text" name="host_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['HOST'] ?>">
                        <label class="input_text add_connection_label" for="con_db_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_name_db') ?></label>
                        <input type="text" name="db_name_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['DB'] ?>">
                        <label class="input_text add_connection_label" for="con_user_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_username') ?></label>
                        <input type="text" name="username_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['USER'] ?>">
                    </div>
                    <div>
                        <label class="input_text add_connection_label" for="con_password"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_password') ?></label>
                        <div class="wrapper-password">
                            <input type="password" name="password_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['PASS'] ?>" id="con_password_edit">
                            <div href="#" class="password-control" onclick="return show_hide_password_edit(this);">
                                <svg viewBox="0 0 640 512">
                                    <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c5.2-11.8 8-24.8 8-38.5c0-53-43-96-96-96c-2.8 0-5.6 .1-8.4 .4c5.3 9.3 8.4 20.1 8.4 31.6c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zm223.1 298L373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5z" />
                                </svg>
                            </div>
                        </div>
                        <label class="input_text add_connection_label" for="con_port"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_port') ?></label>
                        <input type="text" name="port_edit" value="3306" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['PORT'] ?>">
                    </div>
                </div>
                <div class="wrapper_connection_option">
                    <div>
                        <div class="last_inputs">
                            <div>
                                <label class="input_text add_connection_label" for="con_table_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_table_name') ?></label>
                                <input type="text" name="table_name_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['table'] ?>">
                            </div>
                            <?php if ($edit_info[0] == 'LevelsRanks') : ?>
                                <div id="rank_pack_connection_edit">
                                    <label class="input_text add_connection_label" for="con_rank_pack"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_rank_pack') ?></label>
                                    <input type="text" name="rank_pack_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['ranks_pack'] ?>">
                                </div>
                            <?php endif; ?>
                            <div>
                                <label class="input_text add_connection_label" for="con_server_name"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_name') ?></label>
                                <input type="text" name="server_name_edit" value="<?= $db_data_file[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['name'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="adm_save">
                <input class="secondary_btn mt10 w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save_change') ?>">
            </div>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_mod_list') ?></h5>
        </div>
        <div class="card-block">
            <div class="list_mods no-scrollbar">
                <?php for ($i_db = 0; $i_db < $Db->mod_count; $i_db++) : ?>
                    <div class="line_mod">
                        <?= $Db->mod_name[$i_db] ?>
                        <button class="secondary_btn btn_delete" name="<?= $Db->mod_name[$i_db] ?>" onclick="action_db_delete_mod(this, this.getAttribute('name'))">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_delete') ?>
                        </button>
                    </div>
                <?php endfor ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_configure') ?></h5>
        </div>
        <div class="card-container">
            <div class="input-form">
                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_mod') ?></div>
                <select style="display: none;" class="custom-select" id="mods" onchange="changeConnection(this.value)" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_take_mod') ?>">
                    <option value="-1" disabled selected></option>
                    <option value="LevelsRanks">Levels Ranks</option>
                    <option value="IksAdmin">IksAdmin</option>
                    <option value="AdminSystem">AdminSystem</option>
                    <option value="Vips">Vips</option>
                    <option value="lk">lk</option>
                    <option value="Reports">Reports</option>
                    <option value="Shop">Shop</option>
                    <option value="custom"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_custom_mode') ?></option>
                </select>
                <div class="custom_mode" id="custom_mod_wrapper" style="display:none;">
                    <label for="custom_mod_name" class="input_text add_connection_label"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_enter_mode_name') ?></label>
                    <input type="text" name="custom_mod" id="custom_mod_name">
                </div>
            </div>
            <div class="input-form">
                <a class="secondary_btn w100" type="input" onclick="changeNameModule()" id="add_conection_button" href="#"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Add_con') ?></a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_list_con') ?></h5>
        </div>
        <div class="card-block">
            <div class="modern_table">
                <div class="mt_header_1">
                    <li>
                        <span><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_mod') ?></span>
                        <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_user') ?></span>
                        <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_db_con') ?></span>
                        <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_table_prefix') ?></span>
                        <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                        <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                    </li>
                </div>
                <div class="mt_content_1 mb20 no-scrollbar">
                    <?php for ($i_db = 0, $_c = sizeof($db_data); $i_db < $_c; $i_db++) : ?>
                        <li>
                            <span><?= $db_data[$i_db]['DB_mod'] ?></span>
                            <span class="none_span"><?= $db_data[$i_db]['USER'] ?></span>
                            <span class="none_span"><?= $db_data[$i_db]['DB'] ?></span>
                            <span class="none_span"><?= $db_data[$i_db]['Table'] ?></span>
                            <span class="green_color cursor_p">
                                <a type="input" href="<?php echo set_url_section(get_url(2), 'data', sprintf('%s;%d;%d;%d', $db_data[$i_db]['DB_mod'], $db_data[$i_db]['USER_ID'], $db_data[$i_db]['DB_num'], $db_data[$i_db]['table_id'])) ?>#edit_connect"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_change_menu') ?></a>
                            </span>
                            <span name="<?= sprintf('%s;%d;%d;%d', $db_data[$i_db]['DB_mod'], $db_data[$i_db]['USER_ID'], $db_data[$i_db]['DB_num'], $db_data[$i_db]['table_id']) ?>" class="red_color cursor_p" onclick="action_db_delete_table(this, this.getAttribute('name'))">
                                <?= $Translate->get_translate_phrase('_Delete_Action') ?>
                            </span>
                        </li>
                    <?php endfor ?>
                </div>
            </div>
        </div>
    </div>
</div>