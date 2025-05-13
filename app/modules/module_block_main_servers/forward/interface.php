<script>
    let servers = <?= json_encode(action_array_keep_keys($General->server_list, ['ip', 'fakeip', 'name_custom', 'server_mod', 'server_country', 'server_city', 'server_bage'])) ?>;
    let site = <?= json_encode($Db->query("Core", 0, 0, "SELECT COUNT(*) FROM `lr_web_online`")) ?>;
</script>
<div class="row" <?php $option = require MODULESCACHE . 'template_neo/settings_neo.php';
                    if ($option['hide_filter'] == 1) {
                        echo 'style="display:none;"';
                    } ?>>
    <div class="col-md-12">
        <div class="servers_filter card">
            <div class="filter_chips">
                <button class="chips_btn chips_active <?php if ($option['stretch_filter'] == 1) {
                                                            echo 'fill_width';
                                                        } ?> mode" data-mode="Все"><?= $Translate->get_translate_module_phrase('module_block_main_servers', '_AllMod') ?></button>
                <?php $added_modes = array();
                foreach ($General->server_list as $server) :
                    $server_mode = $server['server_mod'];
                    if (!in_array($server_mode, $added_modes)) :
                        array_push($added_modes, $server_mode); ?>
                        <button class="chips_btn <?php if ($option['stretch_filter'] == 1) {
                                                        echo 'fill_width';
                                                    } ?> mode" data-mode="<?= $server_mode; ?>"><?= $server_mode; ?></button>
                <?php endif;
                endforeach; ?>
            </div>
            <a id="updateservers" data-tippy-content="Обновить информацию" data-tippy-placement="top">
                <svg viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="servers_wrap">
            <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) : ?>
                <div class="server_block" id="server-mode-<?= $i_server ?>">
                    <div class="server_map_image">
                        <img class="map" ondrag="return false" ondragstart="return false" id="server-map-image-<?= $i_server ?>" src="<?= $General->arr_general['site'] ?>storage/cache/img/maps/730/-.jpg" alt="" title="">
                    </div>
                    <div class="top_server_block">
                        <div class="server_info_block">
                            <div class="server_name_ip copybtn3" id="copy_btn_<?= $i_server ?>" data-clipboard-text="" data-tippy-content="<?= $Translate->get_translate_phrase('_TakeIp') ?>" data-tippy-placement="right">
                                <?php if ($General->server_list[$i_server]['server_bage']) : ?>
                                    <div class="server_badge" id="server-bage-<?= $i_server ?>"></div>
                                <?php endif; ?>
                                <div class="server_name_custom" id="server-name-<?= $i_server ?>"><?= $Translate->get_translate_module_phrase('module_block_main_servers', '_Loading') ?></div>
                                <div class="btn-clipboard">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="server_players_mapname">
                                <div class="server_players_block">
                                    <div id="server-players-<?= $i_server ?>">0/0</div>
                                </div>
                                <div class="server_map_name" id="server-map-<?= $i_server ?>"><?= $Translate->get_translate_module_phrase('module_block_main_servers', '_Loading') ?></div>
                                <div class="server_geoip">
                                    <div <?php if ($option['hide_country'] == 1) : ?>style="display:none;" <?php endif; ?> class="server_country" id="server-country-<?= $i_server ?>"></div>
                                    <div <?php if ($option['hide_city'] == 1) : ?>style="display:none;" <?php endif; ?>class="server_city" id="server-city-<?= $i_server ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="server_button_play">
                            <button class="server_button play" id="<?= $i_server ?>" onclick="get_players_data(id)" href="javascript:void(0);">
                                <svg viewBox="0 0 384 512">
                                    <path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="bottom_server_block">
                        <div class="progress">
                            <div class="progress-value" id="progess-formula-<?= $i_server ?>"></div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
<?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) : ?>
    <div id="server-players-online-<?= $i_server ?>" class="modal-window-server modal_players_online">
        <div class="modal-card">
            <div class="modal-card__header">
                <a title="" id="<?= $i_server ?>" onclick="close_modal(id)" href="javascript:void(0);" class="modal-btn__close">
                    <svg viewBox="0 0 320 512">
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                    </svg>
                </a>
                <div class="cover server-modal__bg">
                    <img ondrag="return false" ondragstart="return false" id="server-map-image-modal-<?= $i_server ?>" src="<?= $General->arr_general['site'] ?>storage/cache/img/maps/730/-.jpg" alt="" title="">
                    <div class="shadow"></div>
                </div>
                <div class="server-modal__header">
                    <div class="map_name_block">
                        <div class="server_map_now_play_text">
                            <?= $Translate->get_translate_module_phrase('module_block_main_servers', '_CurrentMapPlay') ?>
                        </div>
                        <div class="server_map_name_second" id="server-maptwo-<?= $i_server ?>">
                            <?= $Translate->get_translate_module_phrase('module_block_main_servers', '_Loading') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mon_header">
                <span class="mon_player_name"><?= $Translate->get_translate_module_phrase('module_block_main_servers', '_CurrentPlayers') ?> <span id="server-players-modal-<?= $i_server ?>" class="players_modal">0/0</span></span>
                <span class="non_mob"><?= $Translate->get_translate_phrase('_Point') ?></span>
                <span><?= $Translate->get_translate_phrase('_Play_time') ?></span>
            </div>
            <ul class="mon_list_body mon_list_scroll no-scrollbar" id="players_online_<?= $i_server ?>"></ul>
            <div class="modal-card__footer">
                <a class="secondary_btn modal-btn_copy btn-clipboard copybtn3 w100" id="copy_btnsecond_<?= $i_server ?>" data-clipboard-text="">
                    <svg viewBox="0 0 512 512">
                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z" />
                    </svg>
                    <?= $Translate->get_translate_phrase('_TakeIp') ?>
                </a>
                <a class="secondary_btn modal-btn w100 non_mob" id="connect_server_<?= $i_server ?>">
                    <svg viewBox="0 0 496 512">
                        <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                    </svg>
                    <?= $Translate->get_translate_phrase('_Connect') ?>
                </a>
            </div>
        </div>
    </div>
<?php endfor ?>