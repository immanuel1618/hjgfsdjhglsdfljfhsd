<?php !isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') && die() ?>
<div id="add_server_div" class="modal-window server_form">
    <div class="card">
        <div class="card-header pb0">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Add_Server') ?></div>
            <a href="#" title="Закрыть" class="modal-close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </a>
        </div>
        <form id="add_server_form" enctype="multipart/form-data" method="post">
            <div class="row_adm_modal">
                <div class="add_server_block_form">
                    <div class="">
                        <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server') ?></div>
                    </div>
                    <div class="">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_name') ?></div><input name="server_name_custom" value="">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_TechnoName') ?></div><input name="server_name" value="">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_BageName') ?></div><input name="server_bage" value="">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Ip_Port_Server') ?></div><input name="server_ip_port" value="127.0.0.1:27015">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Ip_Port_View') ?></div><input name="server_ip_port_fake" value="127.0.0.1:27015">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Rcon') ?></div><input type="password" name="server_rcon" value="">
                        </div>
                    </div>
                </div>
                <div class="add_server_block_form">
                    <div class="">
                        <div class="badge">MySQL</div>
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Game_mod') ?></div>
                        <select style="display: none;" class="custom-select" name="server_mod" placeholder="-">
                            <option value="PUBLIC">PUBLIC</option>
                            <option value="AWP">AWP</option>
                            <option value="AIM">AIM</option>
                            <option value="5x5">5x5</option>
                            <option value="2x2">2x2</option>
                            <option value="FPS+">FPS+</option>
                            <option value="ARENA">ARENA</option>
                            <option value="DM">DM</option>
                            <option value="HSDM">HS DM</option>
                            <option value="PISTOLDM">PISTOL DM</option>
                            <option value="DUELS">DUELS</option>
                            <option value="RETAKE">RETAKE</option>
                            <option value="CLUTCH">CLUTCH</option>
                            <option value="HVH">HVH</option>
                            <option value="GUNGAME">GUNGAME</option>
                            <option value="JAIL">JAIL</option>
                            <option value="ZOMBIE">ZOMBIE</option>
                            <option value="MANIAC">MANIAC</option>
                            <option value="HNS">HNS</option>
                            <option value="KNIFE">KNIFE</option>
                            <option value="MINIGAME">MINIGAME</option>
                            <option value="BHOP">BHOP</option>
                            <option value="SURF">SURF</option>
                            <option value="SURFCOMBAT">SURF COMBAT</option>
                            <option value="KZ">KZ</option>
                        </select>
                    </div>
                    <div class="">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stat_Table') ?></div>
                            <select style="display: none;" class="custom-select" name="server_stats" placeholder="-">
                                <?php if (!empty($Db->db_data['LevelsRanks'])) : for ($q = 0, $c = sizeof($Db->db_data['LevelsRanks']); $q < $c; $q++) : ?>
                                        <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['LevelsRanks'][$q]['DB_mod'], $Db->db_data['LevelsRanks'][$q]['USER_ID'], $Db->db_data['LevelsRanks'][$q]['DB_num'], $Db->db_data['LevelsRanks'][$q]['Table']) ?>"><?php echo $Db->db_data['LevelsRanks'][$q]['USER'] . ' -> ' . $Db->db_data['LevelsRanks'][$q]['DB'] . ' -> ' . $Db->db_data['LevelsRanks'][$q]['Table'] . ' ( ' . $Db->db_data['LevelsRanks'][$q]['name'] . ' )' ?></option>
                                <?php endfor;
                                endif ?>
                            </select>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['Vips'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Vip_Table') ?></div>
                                <select style="display: none;" class="custom-select" name="server_vip" onChange="$('.vip_id').css('display','block')" placeholder="-">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['Vips']); $q < $c; $q++) : ?>
                                        <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['Vips'][$q]['DB_mod'], $Db->db_data['Vips'][$q]['USER_ID'], $Db->db_data['Vips'][$q]['DB_num'], $Db->db_data['Vips'][$q]['Table']) ?>"><?php echo $Db->db_data['Vips'][$q]['USER'] . ' -> ' . $Db->db_data['Vips'][$q]['DB'] . ' -> ' . $Db->db_data['Vips'][$q]['Table'] . ' ( ' . $Db->db_data['Vips'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                        <div class=" vip_id">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Vip_Sid') ?></div>
                                <input name="server_vip_id" value="0">
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($Db->db_data['IksAdmin'] || $Db->db_data['AdminSystem'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Sb_Table') ?></div>
                                <?php if (!empty($Db->db_data['IksAdmin'])) : ?>
                                    <select style="display: none;" class="custom-select" name="server_sb" placeholder="-">
                                        <?php for ($q = 0, $c = sizeof($Db->db_data['IksAdmin']); $q < $c; $q++) : ?>
                                            <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['IksAdmin'][$q]['DB_mod'], $Db->db_data['IksAdmin'][$q]['USER_ID'], $Db->db_data['IksAdmin'][$q]['DB_num'], $Db->db_data['IksAdmin'][$q]['Table']) ?>"><?php echo $Db->db_data['IksAdmin'][$q]['USER'] . ' -> ' . $Db->db_data['IksAdmin'][$q]['DB'] . ' -> ' . $Db->db_data['IksAdmin'][$q]['Table'] . ' ( ' . $Db->db_data['IksAdmin'][$q]['name'] . ' )' ?></option>
                                        <?php endfor ?>
                                    </select>
                                <?php endif; ?>
                                <?php if (!empty($Db->db_data['AdminSystem'])) : ?>
                                    <select style="display: none;" class="custom-select" name="server_sb" placeholder="-">
                                        <?php for ($q = 0, $c = sizeof($Db->db_data['AdminSystem']); $q < $c; $q++) : ?>
                                            <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['AdminSystem'][$q]['DB_mod'], $Db->db_data['AdminSystem'][$q]['USER_ID'], $Db->db_data['AdminSystem'][$q]['DB_num'], $Db->db_data['AdminSystem'][$q]['Table']) ?>"><?php echo $Db->db_data['AdminSystem'][$q]['USER'] . ' -> ' . $Db->db_data['AdminSystem'][$q]['DB'] . ' -> ' . $Db->db_data['AdminSystem'][$q]['Table'] . ' ( ' . $Db->db_data['AdminSystem'][$q]['name'] . ' )' ?></option>
                                        <?php endfor ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                            <div class="">
                                <div class="input-form">
                                    <div class="input_text">ID Сервера (Iks_Admin.json || core.ini)</div>
                                    <input name="server_sb_id" value="0">
                                </div>
                            </div>
                        <?php endif;
                    if (!empty($Db->db_data['Shop'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Shop_Table') ?></div>
                                <select style="display: none;" class="custom-select" name="server_shop" placeholder="-">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['Shop']); $q < $c; $q++) : ?>
                                        <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['Shop'][$q]['DB_mod'], $Db->db_data['Shop'][$q]['USER_ID'], $Db->db_data['Shop'][$q]['DB_num'], $Db->db_data['Shop'][$q]['Table']) ?>"><?php echo $Db->db_data['Shop'][$q]['USER'] . ' -> ' . $Db->db_data['Shop'][$q]['DB'] . ' -> ' . $Db->db_data['Shop'][$q]['Table'] . ' ( ' . $Db->db_data['Shop'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($Db->db_data['lk'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Lk_Table') ?></div>
                                <select style="display: none;" class="custom-select" name="server_lk" placeholder="-">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['lk']); $q < $c; $q++) : ?>
                                        <option value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['lk'][$q]['DB_mod'], $Db->db_data['lk'][$q]['USER_ID'], $Db->db_data['lk'][$q]['DB_num'], $Db->db_data['lk'][$q]['Table']) ?>"><?php echo $Db->db_data['lk'][$q]['USER'] . ' -> ' . $Db->db_data['lk'][$q]['DB'] . ' -> ' . $Db->db_data['lk'][$q]['Table'] . ' ( ' . $Db->db_data['lk'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="adm_save">
                <input class="secondary_btn w100" type="submit" name="save_server" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
            </div>
        </form>
    </div>
</div>
<?php if (isset($_GET['id']) || $_GET['id'] !== '') : $server_edit = $Admin->action_get_server($_GET['id']); ?>
<div id="edit_server_div" class="modal-window server_form">
    <div class="card">
        <div class="card-header pb0">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Edit_Server') ?></div>
            <a href="#" title="Закрыть" class="modal-close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </a>
        </div>
        <form id="edit_server_div" enctype="multipart/form-data" method="post">
            <div class="row_adm_modal">
                <input type="hidden" id="server_id" name="server_id_edit" value="<?= $server_edit['id']?>">
                <div class="add_server_block_form">
                    <div class="">
                        <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server') ?></div>
                    </div>
                    <div class="">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_name') ?></div><input name="server_name_custom_edit" value="<?= $server_edit['name_custom']?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_TechnoName') ?></div><input name="server_name_edit" value="<?= $server_edit['name']?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_BageName') ?></div><input name="server_bage_edit" value="<?= $server_edit['server_bage']?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Ip_Port_Server') ?></div><input name="server_ip_port_edit" value="<?= $server_edit['ip']?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Ip_Port_View') ?></div><input name="server_ip_port_fake_edit" value="<?= $server_edit['fakeip']?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Rcon') ?></div><input type="password" name="server_rcon_edit" value="<?= $server_edit['rcon']?>">
                        </div>
                    </div>
                </div>
                <div class="add_server_block_form">
                    <div class="">
                        <div class="badge">MySQL</div>
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Game_mod') ?></div>
                        <select name="server_mod_edit">
                            <option <?= $server_edit['server_mod'] == 'PUBLIC' ? 'selected' : '' ?> value="PUBLIC">PUBLIC</option>
                            <option <?= $server_edit['server_mod'] == 'AWP' ? 'selected' : '' ?> value="AWP">AWP</option>
                            <option <?= $server_edit['server_mod'] == 'AIM' ? 'selected' : '' ?> value="AIM">AIM</option>
                            <option <?= $server_edit['server_mod'] == '5x5' ? 'selected' : '' ?> value="5x5">5x5</option>
                            <option <?= $server_edit['server_mod'] == '2x2' ? 'selected' : '' ?> value="2x2">2x2</option>
                            <option <?= $server_edit['server_mod'] == 'FPS+' ? 'selected' : '' ?> value="FPS+">FPS+</option>
                            <option <?= $server_edit['server_mod'] == 'ARENA' ? 'selected' : '' ?> value="ARENA">ARENA</option>
                            <option <?= $server_edit['server_mod'] == 'DM' ? 'selected' : '' ?> value="DM">DM</option>
                            <option <?= $server_edit['server_mod'] == 'HSDM' ? 'selected' : '' ?> value="HSDM">HS DM</option>
                            <option <?= $server_edit['server_mod'] == 'PISTOLDM' ? 'selected' : '' ?> value="PISTOLDM">PISTOL DM</option>
                            <option <?= $server_edit['server_mod'] == 'DUELS' ? 'selected' : '' ?> value="DUELS">DUELS</option>
                            <option <?= $server_edit['server_mod'] == 'RETAKE' ? 'selected' : '' ?> value="RETAKE">RETAKE</option>
                            <option <?= $server_edit['server_mod'] == 'CLUTCH' ? 'selected' : '' ?> value="CLUTCH">CLUTCH</option>
                            <option <?= $server_edit['server_mod'] == 'HVH' ? 'selected' : '' ?> value="HVH">HVH</option>
                            <option <?= $server_edit['server_mod'] == 'GUNGAME' ? 'selected' : '' ?> value="GUNGAME">GUNGAME</option>
                            <option <?= $server_edit['server_mod'] == 'JAIL' ? 'selected' : '' ?> value="JAIL">JAIL</option>
                            <option <?= $server_edit['server_mod'] == 'ZOMBIE' ? 'selected' : '' ?> value="ZOMBIE">ZOMBIE</option>
                            <option <?= $server_edit['server_mod'] == 'MANIAC' ? 'selected' : '' ?> value="MANIAC">MANIAC</option>
                            <option <?= $server_edit['server_mod'] == 'HNS' ? 'selected' : '' ?> value="HNS">HNS</option>
                            <option <?= $server_edit['server_mod'] == 'KNIFE' ? 'selected' : '' ?> value="KNIFE">KNIFE</option>
                            <option <?= $server_edit['server_mod'] == 'MINIGAME' ? 'selected' : '' ?> value="MINIGAME">MINIGAME</option>
                            <option <?= $server_edit['server_mod'] == 'BHOP' ? 'selected' : '' ?> value="BHOP">BHOP</option>
                            <option <?= $server_edit['server_mod'] == 'SURF' ? 'selected' : '' ?> value="SURF">SURF</option>
                            <option <?= $server_edit['server_mod'] == 'SURFCOMBAT' ? 'selected' : '' ?> value="SURFCOMBAT">SURF COMBAT</option>
                            <option <?= $server_edit['server_mod'] == 'KZ' ? 'selected' : '' ?> value="KZ">KZ</option>
                        </select>
                    </div>
                    <div class="">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stat_Table') ?></div>
                            <select name="server_stats_edit">
                                <?php if (!empty($Db->db_data['LevelsRanks'])) : for ($q = 0, $c = sizeof($Db->db_data['LevelsRanks']); $q < $c; $q++) : ?>
                                        <option <?= $server_edit['server_stats'] == sprintf('%s;%d;%d;%s', $Db->db_data['LevelsRanks'][$q]['DB_mod'], $Db->db_data['LevelsRanks'][$q]['USER_ID'], $Db->db_data['LevelsRanks'][$q]['DB_num'], $Db->db_data['LevelsRanks'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['LevelsRanks'][$q]['DB_mod'], $Db->db_data['LevelsRanks'][$q]['USER_ID'], $Db->db_data['LevelsRanks'][$q]['DB_num'], $Db->db_data['LevelsRanks'][$q]['Table']) ?>"><?php echo $Db->db_data['LevelsRanks'][$q]['USER'] . ' -> ' . $Db->db_data['LevelsRanks'][$q]['DB'] . ' -> ' . $Db->db_data['LevelsRanks'][$q]['Table'] . ' ( ' . $Db->db_data['LevelsRanks'][$q]['name'] . ' )' ?></option>
                                <?php endfor;
                                endif ?>
                            </select>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['Vips'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Vip_Table') ?></div>
                                <select name="server_vip_edit" onChange="$('.vip_id').css('display','block')">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['Vips']); $q < $c; $q++) : ?>
                                        <option <?= $server_edit['server_vip'] == sprintf('%s;%d;%d;%s', $Db->db_data['Vips'][$q]['DB_mod'], $Db->db_data['Vips'][$q]['USER_ID'], $Db->db_data['Vips'][$q]['DB_num'], $Db->db_data['Vips'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['Vips'][$q]['DB_mod'], $Db->db_data['Vips'][$q]['USER_ID'], $Db->db_data['Vips'][$q]['DB_num'], $Db->db_data['Vips'][$q]['Table']) ?>"><?php echo $Db->db_data['Vips'][$q]['USER'] . ' -> ' . $Db->db_data['Vips'][$q]['DB'] . ' -> ' . $Db->db_data['Vips'][$q]['Table'] . ' ( ' . $Db->db_data['Vips'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                        <div class=" vip_id" style="display: block;">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Vip_Sid') ?></div>
                                <input name="server_vip_id_edit" value="<?= $server_edit['server_vip_id']?>">
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($Db->db_data['IksAdmin'] || $Db->db_data['AdminSystem'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Sb_Table') ?></div>
                                <?php if (!empty($Db->db_data['IksAdmin'])) : ?>
                                    <select name="server_sb_edit">
                                        <?php for ($q = 0, $c = sizeof($Db->db_data['IksAdmin']); $q < $c; $q++) : ?>
                                            <option <?= $server_edit['server_sb'] == sprintf('%s;%d;%d;%s', $Db->db_data['IksAdmin'][$q]['DB_mod'], $Db->db_data['IksAdmin'][$q]['USER_ID'], $Db->db_data['IksAdmin'][$q]['DB_num'], $Db->db_data['IksAdmin'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['IksAdmin'][$q]['DB_mod'], $Db->db_data['IksAdmin'][$q]['USER_ID'], $Db->db_data['IksAdmin'][$q]['DB_num'], $Db->db_data['IksAdmin'][$q]['Table']) ?>"><?php echo $Db->db_data['IksAdmin'][$q]['USER'] . ' -> ' . $Db->db_data['IksAdmin'][$q]['DB'] . ' -> ' . $Db->db_data['IksAdmin'][$q]['Table'] . ' ( ' . $Db->db_data['IksAdmin'][$q]['name'] . ' )' ?></option>
                                        <?php endfor ?>
                                    </select>
                                <?php endif; ?>
                                <?php if (!empty($Db->db_data['AdminSystem'])) : ?>
                                    <select name="server_sb_edit">
                                        <?php for ($q = 0, $c = sizeof($Db->db_data['AdminSystem']); $q < $c; $q++) : ?>
                                            <option <?= $server_edit['server_sb'] == sprintf('%s;%d;%d;%s', $Db->db_data['AdminSystem'][$q]['DB_mod'], $Db->db_data['AdminSystem'][$q]['USER_ID'], $Db->db_data['AdminSystem'][$q]['DB_num'], $Db->db_data['AdminSystem'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['AdminSystem'][$q]['DB_mod'], $Db->db_data['AdminSystem'][$q]['USER_ID'], $Db->db_data['AdminSystem'][$q]['DB_num'], $Db->db_data['AdminSystem'][$q]['Table']) ?>"><?php echo $Db->db_data['AdminSystem'][$q]['USER'] . ' -> ' . $Db->db_data['AdminSystem'][$q]['DB'] . ' -> ' . $Db->db_data['AdminSystem'][$q]['Table'] . ' ( ' . $Db->db_data['AdminSystem'][$q]['name'] . ' )' ?></option>
                                        <?php endfor ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                            <div class="">
                                <div class="input-form">
                                    <div class="input_text">ID Сервера (Iks_Admin.json || core.ini)</div>
                                    <input name="server_sb_id_edit" value="<?= $server_edit['server_sb_id']?>">
                                </div>
                            </div>
                    <?php endif;
                    if (!empty($Db->db_data['Shop'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Shop_Table') ?></div>
                                <select name="server_shop_edit">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['Shop']); $q < $c; $q++) : ?>
                                        <option <?= $server_edit['server_shop'] == sprintf('%s;%d;%d;%s', $Db->db_data['Shop'][$q]['DB_mod'], $Db->db_data['Shop'][$q]['USER_ID'], $Db->db_data['Shop'][$q]['DB_num'], $Db->db_data['Shop'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['Shop'][$q]['DB_mod'], $Db->db_data['Shop'][$q]['USER_ID'], $Db->db_data['Shop'][$q]['DB_num'], $Db->db_data['Shop'][$q]['Table']) ?>"><?php echo $Db->db_data['Shop'][$q]['USER'] . ' -> ' . $Db->db_data['Shop'][$q]['DB'] . ' -> ' . $Db->db_data['Shop'][$q]['Table'] . ' ( ' . $Db->db_data['Shop'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($Db->db_data['lk'])) : ?>
                        <div class="">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Lk_Table') ?></div>
                                <select name="server_lk_edit">
                                    <?php for ($q = 0, $c = sizeof($Db->db_data['lk']); $q < $c; $q++) : ?>
                                        <option <?= $server_edit['server_lk'] == sprintf('%s;%d;%d;%s', $Db->db_data['lk'][$q]['DB_mod'], $Db->db_data['lk'][$q]['USER_ID'], $Db->db_data['lk'][$q]['DB_num'], $Db->db_data['lk'][$q]['Table']) ? 'selected' : '' ?> value="<?= sprintf('%s;%d;%d;%s', $Db->db_data['lk'][$q]['DB_mod'], $Db->db_data['lk'][$q]['USER_ID'], $Db->db_data['lk'][$q]['DB_num'], $Db->db_data['lk'][$q]['Table']) ?>"><?php echo $Db->db_data['lk'][$q]['USER'] . ' -> ' . $Db->db_data['lk'][$q]['DB'] . ' -> ' . $Db->db_data['lk'][$q]['Table'] . ' ( ' . $Db->db_data['lk'][$q]['name'] . ' )' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="adm_save">
                <input class="secondary_btn w100" type="submit" name="save_server_edit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
            </div>
        </form>
    </div>
</div>
<?php endif;?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Settings') ?></div>
        </div>
        <div class="card-container pb0">
            <?php $settings_neo = $General->get_neo_options();
            if (($Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_mod') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_country') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_city') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_sb_id') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_bage')) == false) : ?>
                <form id="create_table" style="margin-bottom: 10px;">
                    <button class="secondary_btn w100"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Recreate_db_Servers') ?></button>
                </form>
            <?php endif; ?>
            <div class="form_block">
                <form id="hide_filter_form">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Hide_filter_Servers') ?></div>
                        <input class="border-checkbox" type="checkbox" name="hide_filter" id="hide_filter" <?php $settings_neo['hide_filter'] === 1 && print 'checked' ?>>
                        <label class="border-checkbox-label" for="hide_filter"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_On_Off_checkbox') ?></label>
                    </div>
                </form>
                <?php if ($settings_neo['hide_filter'] == 0) : ?>
                    <form id="stretch_filter_form">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stretch_filter_buttons') ?></div>
                            <input class="border-checkbox" type="checkbox" name="stretch_filter" id="stretch_filter" <?php $settings_neo['stretch_filter'] === 1 && print 'checked' ?>>
                            <label class="border-checkbox-label" for="stretch_filter"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_On_Off_checkbox') ?></label>
                        </div>
                    </form>
                <?php endif; ?>
                <form id="hide_city_form">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Hide_the_city_in_monitoring') ?></div>
                        <input class="border-checkbox" type="checkbox" name="hide_city" id="hide_city" <?php $settings_neo['hide_city'] === 1 && print 'checked' ?>>
                        <label class="border-checkbox-label" for="hide_city"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_On_Off_checkbox') ?></label>
                    </div>
                </form>
                <form id="hide_country_form">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Hide_country_in_monitoring') ?></div>
                        <input class="border-checkbox" type="checkbox" name="hide_country" id="hide_country" <?php $settings_neo['hide_country'] === 1 && print 'checked' ?>>
                        <label class="border-checkbox-label" for="hide_country"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_On_Off_checkbox') ?></label>
                    </div>
                </form>
            </div>
        </div>
        <?php if (($Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_mod') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_country') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_city') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_sb_id') && $Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_bage')) == true) : ?>
            <div class="card-header">
                <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_setting_list') ?></div>
            </div>
            <div class="card-block">
                <div class="modern_table">
                    <div class="mt_header">
                        <li>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Id_server') ?></span>
                            <span><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_Name') ?></span>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_IpPort_server') ?></span>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Game_mod') ?></span>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Country_server') ?></span>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_City_server') ?></span>
                            <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                            <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                        </li>
                    </div>
                    <div class="mt_content no-scrollbar">
                        <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) : ?>
                            <li id="<?= $General->server_list[$i_server]['id'] ?>">
                                <span class="none_span"><?= $General->server_list[$i_server]['id'] ?></span>
                                <span><?= $General->server_list[$i_server]['name'] ?></span>
                                <span class="none_span"><?= $General->server_list[$i_server]['ip'] ?></span>
                                <span class="none_span"><?= $General->server_list[$i_server]['server_mod'] ?></span>
                                <span class="none_span"><?php if ($General->server_list[$i_server]['server_mod'] == 'Отредактируйте сервер!') : ?>-<?php else : ?><img class="country_flag_img" src="/storage/cache/img/icons/custom/flags/<?= mb_strtolower($General->server_list[$i_server]['server_country']) ?>.svg" alt=""><?php endif; ?></span>
                                <span class="none_span"><?php if ($General->server_list[$i_server]['server_mod'] == 'Отредактируйте сервер!') : ?>-<?php else : ?><?= $General->server_list[$i_server]['server_city'] ?><?php endif; ?></span>
                                <span class="green_color cursor_p">
                                    <a type="input" href="<?php echo set_url_section(get_url(2), 'id', $General->server_list[$i_server]['id']) ?>#edit_server_div"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_change_menu') ?></a>
                                </span>
                                <span class="red_color cursor_p" onclick="delete_server(this)">
                                    <?= $Translate->get_translate_phrase('_Delete_Action') ?>
                                </span>
                            </li>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="card-container">
                <div style="display: flex; float: left;">
                    <a class="secondary_btn" type="input" href="#add_server_div"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Add_Server') ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>