<?php switch ($res_system[$server_group]['admin_mod']):
    case 'AdminSystem': ?>
        <div class="container_grid">
            <div class="fix_grid">
                <div class="container_text_access">
                    <svg viewBox="0 0 640 512">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminList') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminListDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <input class="input_search" name="search" id="search_table_admin" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
                    <div class="h346 scroll">
                        <div class="flex_table_proff" id="table_result"></div>
                        <div id="table_result_error"></div>
                        <div class="flex_table_proff" id="table_list_foreach">
                            <?php foreach ($MSAdmin as $key) : ?>
                                <div class="user_card_bg">
                                    <div class="user_flex_av_nn">
                                        <?php $General->get_js_relevance_avatar($key['steamid'], 1) ?>
                                        <a href="/profiles/<?= $key['steamid'] ?>/?search=1"><img class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                echo 'avatar';
                                                                                                                            } else {
                                                                                                                                echo $key['steamid'];
                                                                                                                            } ?>" <?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                        echo 'avatarid="' . $key['steamid'] . '"';
                                                                                                                                    } ?> src="<?= $General->getAvatar($key['steamid'], 1) ?>" title="" alt=""></a>
                                        <div class="info_nn">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                                                </svg></div>
                                            <a class="info_a" href="/profiles/<?= $key['steamid'] ?>/?search=1"><?= empty($General->checkName($key['steamid'])) ? action_text_clear($key['name']) : action_text_clear($General->checkName($key['steamid'])) ?></a>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512">
                                                    <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= $key['steamid'] ?></span>
                                        </div>
                                        <div class="info_deff_comm">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1') ?>"><svg viewBox="0 0 576 512">
                                                    <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php $groupFound = false;
                                                foreach ($Core->AdminCore()->Groups() as $group) {
                                                    if ($key['group_id'] == 0) {
                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                                        $groupFound = true;
                                                        break;
                                                    } else {
                                                        if ($key['group_id'] == $group['id']) {
                                                            echo action_text_clear($group['name']);
                                                            $groupFound = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                                if (!$groupFound) {
                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                                } ?>
                                            </span>
                                        </div>
                                        <?php if (empty($key['flags'])) {
                                            foreach ($Core->AdminCore()->Groups() as $group) {
                                                if ($key['group_id'] == $group['id']) {
                                                    $flasg_del = $group['flags'];
                                                }
                                            }
                                        } else {
                                            $flasg_del = $key['flags'];
                                        } ?>
                                        <?php if ($Core->GetCache('settings')['restriction_flag_z'] == 0 || (in_array('z', str_split($flasg_del)) == false || $_SESSION['user_admin'])) : ?>
                                            <a class="btn_req" href="<?= $Core->set_url_section_new(get_url(2), ['ms_admin_edit' => $key['id'], 'group_id' => $key['group_id']]) ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSRedAdmn') ?>" data-tippy-placement="top">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                </svg>
                                            </a>
                                            <button class="btn_del" id="ms_admin_del" id_del="<?= $key['id'] ?>" id_group="<?= $key['group_id'] ?>" id_server="<?= $server_id ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAdm') ?>" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512">
                                                    <path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="user_flex_av_nn">
                                        <div class="info_access_admin">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags') ?>">
                                                <svg viewBox="0 0 448 512">
                                                    <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?= action_text_clear($flasg_del); ?>
                                            </span>
                                        </div>
                                        <div class="info_access_time">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                                                </svg></div>
                                            <span class="info_span"><?php if (empty($key['end'])) {
                                                                        echo $Translate->get_translate_phrase('_Forever');
                                                                    } elseif ($key['end'] < time()) {
                                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                                                    } else {
                                                                        echo $Core->action_time_exchange_exact($key['end'] - time());
                                                                    } ?></span>
                                        </div>
                                        <div class="info_access">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet') ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z" />
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php if ($key['immunity'] == 0 || $key['immunity'] == -1) {
                                                    foreach ($Core->AdminCore()->Groups() as $group) {
                                                        if ($key['group_id'] == $group['id']) {
                                                            echo $group['immunity'];
                                                        }
                                                    }
                                                } else {
                                                    echo $key['immunity'];
                                                } ?>
                                            </span>
                                        </div>
                                        <?php $WarnCount = ceil($Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $key['steamid'] . " AND `time` > UNIX_TIMESTAMP()")[0]); ?>
                                        <div class="info_access_warn">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPred') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                                                </svg></div>
                                            <span class="info_a"><?= $WarnCount ?>/<?= $Core->GetCache('settings')['count_warn'] ?></span>
                                        </div>
                                        <div class="info_access_type">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput') ?> <?php if ($key['server_id'] == '-1') {
                                                                                                                                                                                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers');
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo $key['server_id'];
                                                                                                                                                                                                                } ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="pagination">
                    <?php if ($page_num != 1): ?>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512">
                                <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                            </svg></a>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512">
                                <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                            </svg></a>
                    <?php endif; ?>
                    <?php if ($page_max < 5): for ($i = 1; $i <= $page_max; $i++): ?>
                            <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                        <?php endfor;
                    else: for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++): ?>
                            <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                    <?php endfor;
                    endif; ?>
                    <?php if ($page_num != $page_max): ?>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512">
                                <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                            </svg></a>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512">
                                <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                            </svg></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (empty($_GET['ms_admin_edit'])) : ?>
                <form id="ms_admins_add">
                    <div class="container_text_access2">
                        <svg viewBox="0 0 448 512">
                            <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                        </svg>
                        <div class="container_text_settings_text">
                            <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin') ?></span>
                            <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminForm') ?></span>
                        </div>
                    </div>
                    <div class="card_settings">
                        <div class="h411_max scroll">
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 496 512">
                                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                                        </svg>
                                        STEAMID
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="steamid" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." required>
                                </div>
                            </div>
                            <?php if ($Core->GetCache('settings')['group_choice_admin'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 640 512">
                                                <path d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0zM320 160a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM144 256a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm312 40a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM226.9 491.4L200 441.5V480c0 17.7-14.3 32-32 32H120c-17.7 0-32-14.3-32-32V441.5L61.1 491.4c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l37.9-70.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c16.3 0 31.9 4.5 45.4 12.6l33.6-62.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c32.4 0 62.1 17.8 77.5 46.3l33.6 62.3c13.5-8.1 29.1-12.6 45.4-12.6h19.5c32.4 0 62.1 17.8 77.5 46.3l37.9 70.3c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8L552 441.5V480c0 17.7-14.3 32-32 32H472c-17.7 0-32-14.3-32-32V441.5l-26.9 49.9c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l36.3-67.5c-1.7-1.7-3.2-3.6-4.3-5.8L376 345.5V400c0 17.7-14.3 32-32 32H296c-17.7 0-32-14.3-32-32V345.5l-26.9 49.9c-1.2 2.2-2.6 4.1-4.3 5.8l36.3 67.5c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdm') ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($Core->AdminCore()->Groups())) : ?>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                    <label for="group_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else : ?>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminGroupNo') ?>
                                    <?php endif; ?>
                                </div>
                            <?php else : ?>
                                Данная версия модуля работает только с группами
                            <?php endif; ?>
                            <?php if ($Core->GetCache('settings')['time_choice_privileges'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovTime') ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($Core->GetCache('privilegestime'))) : ?>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('privilegestime') as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="time_choice_privileges" id="time_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                    <label for="time_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name_time']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminTimeNo') ?>
                                    <?php endif; ?>
                                </div>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSov') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <div class="number">
                                            <?php endif; ?>
                                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>" data-tippy-placement="right">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                                </svg>
                                            </span>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                                <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                                <input type="number" min="0" name="end" placeholder="30">
                                                <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                            <?php else : ?>
                                                <input type="number" min="0" name="end" placeholder="30">
                                            <?php endif; ?>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDayTime') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <div class="number">
                                            <?php endif; ?>
                                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>" data-tippy-placement="right">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                                </svg>
                                            </span>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                                <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                                <input type="number" min="0" name="end" placeholder="30">
                                                <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                            <?php else : ?>
                                                <input type="number" min="0" name="end" placeholder="30">
                                            <?php endif; ?>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($Core->GetCache('serversiks'))) : ?>
                                <?php if ($server_id == 'all') : ?>
                                    <div class="input_container">
                                        <div class="input_form">
                                            <div class="input_text">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                            </div>
                                        </div>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('serversiks') as $key) : ?>
                                                <div class="check_button_card input-form">
                                                    <input class="border-checkbox" type="checkbox" name="server_id[]" id="server_id<?= $key['server_id'] ?>" value="<?= $key['server_id'] ?>">
                                                    <label for="server_id<?= $key['server_id'] ?>" class="border-checkbox-label">[<?= $key['server_id'] ?>] <?= action_text_clear($key['server_name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="server_id" placeholder="1">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin2') ?>">
                    </div>
                </form>
            <?php endif; ?>
            <?php if (!empty($_GET['ms_admin_edit'])) : $key_edit = $Core->AdminCore()->Admin_Info_Get($_GET['ms_admin_edit'], $_GET['group_id']); ?>
                <form id="ms_admin_edit">
                    <div class="container_text_access2">
                        <svg viewBox="0 0 448 512">
                            <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                        </svg>
                        <div class="container_text_settings_text">
                            <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAdmin1') ?></span>
                            <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormEditAdmin') ?></span>
                        </div>
                    </div>
                    <div class="card_settings">
                        <div class="h411_max scroll">
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 496 512">
                                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                                        </svg>
                                        STEAMID
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="steamid" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." value="<?= $key_edit['steamid'] ?>" required>
                                </div>
                            </div>
                            <?php if ($Core->GetCache('settings')['group_choice_admin'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 640 512">
                                                <path d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0zM320 160a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM144 256a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm312 40a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM226.9 491.4L200 441.5V480c0 17.7-14.3 32-32 32H120c-17.7 0-32-14.3-32-32V441.5L61.1 491.4c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l37.9-70.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c16.3 0 31.9 4.5 45.4 12.6l33.6-62.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c32.4 0 62.1 17.8 77.5 46.3l33.6 62.3c13.5-8.1 29.1-12.6 45.4-12.6h19.5c32.4 0 62.1 17.8 77.5 46.3l37.9 70.3c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8L552 441.5V480c0 17.7-14.3 32-32 32H472c-17.7 0-32-14.3-32-32V441.5l-26.9 49.9c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l36.3-67.5c-1.7-1.7-3.2-3.6-4.3-5.8L376 345.5V400c0 17.7-14.3 32-32 32H296c-17.7 0-32-14.3-32-32V345.5l-26.9 49.9c-1.2 2.2-2.6 4.1-4.3 5.8l36.3 67.5c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdm') ?>
                                        </div>
                                    </div>
                                    <div class="card_button_flex_more">
                                        <?php if (!empty($Core->AdminCore()->Groups())) : ?>
                                            <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>" <?php if ($key['id'] == $key_edit['group_id']) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                    <label for="group_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminGroupNo') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                Данная версия модуля работает только с группами
                            <?php endif; ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSec2') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSec2') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="end" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" value="<?php if ($key_edit['end'] == 0) {
                                                                                                                                                                                                            echo 0;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo (float)$key_edit['end'] - time();
                                                                                                                                                                                                        } ?>" required>
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="end" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" value="<?php if ($key_edit['end'] == 0) {
                                                                                                                                                                                                            echo 0;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo (float)$key_edit['end'] - time();
                                                                                                                                                                                                        } ?>" required>
                                        <?php endif; ?>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($Core->GetCache('serversiks'))) : ?>
                                <?php if ($server_id == 'all') : ?>
                                    <div class="input_container">
                                        <div class="input_form">
                                            <div class="input_text">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                            </div>
                                        </div>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('serversiks') as $key) : ?>
                                                <div class="check_button_card input-form">
                                                    <input class="border-checkbox" type="checkbox" name="server_id[]" id="server_id<?= $key['server_id'] ?>" value="<?= $key['server_id'] ?>" <?php if (in_array($key['server_id'], str_split($key_edit['server_id']))) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                    <label for="server_id<?= $key['server_id'] ?>" class="border-checkbox-label">[<?= $key['server_id'] ?>] <?= action_text_clear($key['server_name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="server_id" placeholder="1" value="<?= $key_edit['server_id'] ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveIzm') ?>">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    <?php break;
    case 'IksAdmin': ?>
        <div class="container_grid">
            <div class="fix_grid">
                <div class="container_text_access">
                    <svg viewBox="0 0 640 512">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminList') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminListDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <input class="input_search" name="search" id="search_table_admin" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
                    <div class="h346 scroll">
                        <div class="flex_table_proff" id="table_result"></div>
                        <div id="table_result_error"></div>
                        <div class="flex_table_proff" id="table_list_foreach">
                            <?php foreach ($MSAdmin as $key) : ?>
                                <div class="user_card_bg">
                                    <div class="user_flex_av_nn">
                                        <?php $General->get_js_relevance_avatar($key['steamid'], 1) ?>
                                        <a href="/profiles/<?= $key['steamid'] ?>/?search=1"><img class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                echo 'avatar';
                                                                                                                            } else {
                                                                                                                                echo $key['steamid'];
                                                                                                                            } ?>" <?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                        echo 'avatarid="' . $key['steamid'] . '"';
                                                                                                                                    } ?> src="<?= $General->getAvatar($key['steamid'], 1) ?>" title="" alt=""></a>
                                        <div class="info_nn">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                                                </svg></div>
                                            <a class="info_a" href="/profiles/<?= $key['steamid'] ?>/?search=1"><?= empty($General->checkName($key['steamid'])) ? action_text_clear($key['name']) : action_text_clear($General->checkName($key['steamid'])) ?></a>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512">
                                                    <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= $key['steamid'] ?></span>
                                        </div>
                                        <div class="info_deff_comm">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1') ?>"><svg viewBox="0 0 576 512">
                                                    <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php $groupFound = false;
                                                foreach ($Core->AdminCore()->Groups() as $group) {
                                                    if ($key['group_id'] == 0) {
                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                                        $groupFound = true;
                                                        break;
                                                    } else {
                                                        if ($key['group_id'] == $group['id']) {
                                                            echo action_text_clear($group['name']);
                                                            $groupFound = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                                if (!$groupFound) {
                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroup0');
                                                } ?>
                                            </span>
                                        </div>
                                        <?php if (empty($key['flags'])) {
                                            foreach ($Core->AdminCore()->Groups() as $group) {
                                                if ($key['group_id'] == $group['id']) {
                                                    $flasg_del = $group['flags'];
                                                }
                                            }
                                        } else {
                                            $flasg_del = $key['flags'];
                                        } ?>
                                        <?php if ($Core->GetCache('settings')['restriction_flag_z'] == 0 || (in_array('z', str_split($flasg_del)) == false || $_SESSION['user_admin'])) : ?>
                                            <a class="btn_req" href="<?= $Core->set_url_section_new(get_url(2), ['ms_admin_edit' => $key['id'], 'group_id' => $key['group_id']]) ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSRedAdmn') ?>" data-tippy-placement="top">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                </svg>
                                            </a>
                                            <button class="btn_del" id="ms_admin_del" id_del="<?= $key['id'] ?>" id_group="<?= $key['group_id'] ?>" id_server="<?= $server_id ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAdm') ?>" data-tippy-placement="top">
                                                <svg viewBox="0 0 448 512">
                                                    <path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="user_flex_av_nn">
                                        <div class="info_access_admin">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags') ?>">
                                                <svg viewBox="0 0 448 512">
                                                    <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?= action_text_clear($flasg_del); ?>
                                            </span>
                                        </div>
                                        <div class="info_access_time">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                                                </svg></div>
                                            <span class="info_span"><?php if (empty($key['end'])) {
                                                                        echo $Translate->get_translate_phrase('_Forever');
                                                                    } elseif ($key['end'] < time()) {
                                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                                                    } else {
                                                                        echo $Core->action_time_exchange_exact($key['end'] - time());
                                                                    } ?></span>
                                        </div>
                                        <div class="info_access">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet') ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z" />
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php if ($key['immunity'] == 0 || $key['immunity'] == -1 || $key['immunity'] == null) {
                                                    foreach ($Core->AdminCore()->Groups() as $group) {
                                                        if ($key['group_id'] == $group['id']) {
                                                            echo $group['immunity'];
                                                        }
                                                    }
                                                } else {
                                                    echo $key['immunity'];
                                                } ?>
                                            </span>
                                        </div>
                                        <?php $WarnCount = ceil($Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lvl_web_managersystem_warn` WHERE `steamid` = " . $key['steamid'] . " AND `time` > UNIX_TIMESTAMP()")[0]); ?>
                                        <div class="info_access_warn">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPred') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                                                </svg></div>
                                            <span class="info_a"><?= $WarnCount ?>/<?= $Core->GetCache('settings')['count_warn'] ?></span>
                                        </div>
                                        <div class="info_access_type">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput') ?> <?php if ($key['server_id'] == '-1' || $key['server_id'] == null) {
                                                                                                                                                                                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers');
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo $key['server_id'];
                                                                                                                                                                                                                } ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="pagination">
                    <?php if ($page_num != 1): ?>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512">
                                <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                            </svg></a>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512">
                                <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                            </svg></a>
                    <?php endif; ?>
                    <?php if ($page_max < 5): for ($i = 1; $i <= $page_max; $i++): ?>
                            <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                        <?php endfor;
                    else: for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++): ?>
                            <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                    <?php endfor;
                    endif; ?>
                    <?php if ($page_num != $page_max): ?>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512">
                                <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                            </svg></a>
                        <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512">
                                <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                            </svg></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (empty($_GET['ms_admin_edit'])) : ?>
                <form id="ms_admins_add">
                    <div class="container_text_access2">
                        <svg viewBox="0 0 448 512">
                            <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                        </svg>
                        <div class="container_text_settings_text">
                            <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin') ?></span>
                            <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdminForm') ?></span>
                        </div>
                    </div>
                    <div class="card_settings">
                        <div class="h411_max scroll">
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 496 512">
                                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                                        </svg>
                                        STEAMID
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="steamid" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." required>
                                </div>
                            </div>
                            <?php if ($Core->GetCache('settings')['group_choice_admin'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 640 512">
                                                <path d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0zM320 160a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM144 256a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm312 40a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM226.9 491.4L200 441.5V480c0 17.7-14.3 32-32 32H120c-17.7 0-32-14.3-32-32V441.5L61.1 491.4c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l37.9-70.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c16.3 0 31.9 4.5 45.4 12.6l33.6-62.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c32.4 0 62.1 17.8 77.5 46.3l33.6 62.3c13.5-8.1 29.1-12.6 45.4-12.6h19.5c32.4 0 62.1 17.8 77.5 46.3l37.9 70.3c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8L552 441.5V480c0 17.7-14.3 32-32 32H472c-17.7 0-32-14.3-32-32V441.5l-26.9 49.9c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l36.3-67.5c-1.7-1.7-3.2-3.6-4.3-5.8L376 345.5V400c0 17.7-14.3 32-32 32H296c-17.7 0-32-14.3-32-32V345.5l-26.9 49.9c-1.2 2.2-2.6 4.1-4.3 5.8l36.3 67.5c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdm') ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($Core->AdminCore()->Groups())) : ?>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                    <label for="group_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else : ?>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminGroupNo') ?>
                                    <?php endif; ?>
                                </div>
                            <?php else : ?>
                                Данная версия модуля работает только с группами
                            <?php endif; ?>
                            <?php if ($Core->GetCache('settings')['time_choice_privileges'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovTime') ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($Core->GetCache('privilegestime'))) : ?>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('privilegestime') as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="time_choice_privileges" id="time_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                    <label for="time_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name_time']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminTimeNo') ?>
                                    <?php endif; ?>
                                </div>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSov') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <div class="number">
                                            <?php endif; ?>
                                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>" data-tippy-placement="right">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                                </svg>
                                            </span>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                                <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                                <input type="number" min="0" name="end" placeholder="30">
                                                <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                            <?php else : ?>
                                                <input type="number" min="0" name="end" placeholder="30">
                                            <?php endif; ?>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDayTime') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <div class="number">
                                            <?php endif; ?>
                                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>" data-tippy-placement="right">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                                </svg>
                                            </span>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                                <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                                <input type="number" min="0" name="end" placeholder="30">
                                                <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                            <?php else : ?>
                                                <input type="number" min="0" name="end" placeholder="30">
                                            <?php endif; ?>
                                            <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($Core->GetCache('serversiks'))) : ?>
                                <?php if ($server_id == 'all') : ?>
                                    <div class="input_container">
                                        <div class="input_form">
                                            <div class="input_text">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                            </div>
                                        </div>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('serversiks') as $key) : ?>
                                                <div class="check_button_card input-form">
                                                    <input class="border-checkbox" type="checkbox" name="server_id[]" id="server_id<?= $key['server_id'] ?>" value="<?= $key['server_id'] ?>">
                                                    <label for="server_id<?= $key['server_id'] ?>" class="border-checkbox-label">[<?= $key['server_id'] ?>] <?= action_text_clear($key['server_name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="server_id" placeholder="1">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin2') ?>">
                    </div>
                </form>
            <?php endif; ?>
            <?php if (!empty($_GET['ms_admin_edit'])) : $key_edit = $Core->AdminCore()->Admin_Info_Get($_GET['ms_admin_edit'], $_GET['group_id']); ?>
                <form id="ms_admin_edit">
                    <div class="container_text_access2">
                        <svg viewBox="0 0 448 512">
                            <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                        </svg>
                        <div class="container_text_settings_text">
                            <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAdmin1') ?></span>
                            <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormEditAdmin') ?></span>
                        </div>
                    </div>
                    <div class="card_settings">
                        <div class="h411_max scroll">
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 496 512">
                                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                                        </svg>
                                        STEAMID
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="steamid" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." value="<?= $key_edit['steamid'] ?>" required>
                                </div>
                            </div>
                            <?php if ($Core->GetCache('settings')['group_choice_admin'] == 1) : ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 640 512">
                                                <path d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0zM320 160a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM144 256a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm312 40a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM226.9 491.4L200 441.5V480c0 17.7-14.3 32-32 32H120c-17.7 0-32-14.3-32-32V441.5L61.1 491.4c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l37.9-70.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c16.3 0 31.9 4.5 45.4 12.6l33.6-62.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c32.4 0 62.1 17.8 77.5 46.3l33.6 62.3c13.5-8.1 29.1-12.6 45.4-12.6h19.5c32.4 0 62.1 17.8 77.5 46.3l37.9 70.3c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8L552 441.5V480c0 17.7-14.3 32-32 32H472c-17.7 0-32-14.3-32-32V441.5l-26.9 49.9c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l36.3-67.5c-1.7-1.7-3.2-3.6-4.3-5.8L376 345.5V400c0 17.7-14.3 32-32 32H296c-17.7 0-32-14.3-32-32V345.5l-26.9 49.9c-1.2 2.2-2.6 4.1-4.3 5.8l36.3 67.5c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGroupAdm') ?>
                                        </div>
                                    </div>
                                    <div class="card_button_flex_more">
                                        <?php if (!empty($Core->AdminCore()->Groups())) : ?>
                                            <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                                                <div class="check_button_card">
                                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>" <?php if ($key['id'] == $key_edit['group_id']) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                    <label for="group_choice<?= $key['id'] ?>" class="custom-radio"><?= action_text_clear($key['name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminGroupNo') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                Данная версия модуля работает только с группами
                            <?php endif; ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSec2') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSec2') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="end" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" value="<?php if ($key_edit['end'] == NULL || $key_edit['end'] == 0) {
                                                                                                                                                                                                            echo 0;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo (float)$key_edit['end'] - time();
                                                                                                                                                                                                        } ?>" required>
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="end" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" value="<?php if ($key_edit['end'] == NULL || $key_edit['end'] == 0) {
                                                                                                                                                                                                            echo 0;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo (float)$key_edit['end'] - time();
                                                                                                                                                                                                        } ?>" required>
                                        <?php endif; ?>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($Core->GetCache('serversiks'))) : ?>
                                <?php if ($server_id == 'all') : ?>
                                    <div class="input_container">
                                        <div class="input_form">
                                            <div class="input_text">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path>
                                                </svg>
                                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                            </div>
                                        </div>
                                        <div class="card_button_flex_more">
                                            <?php foreach ($Core->GetCache('serversiks') as $key) : ?>
                                                <div class="check_button_card input-form">
                                                    <input class="border-checkbox" type="checkbox" name="server_id[]" id="server_id<?= $key['server_id'] ?>" value="<?= $key['server_id'] ?>" <?php if (in_array($key['server_id'], str_split($key_edit['server_id']))) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                    <label for="server_id<?= $key['server_id'] ?>" class="border-checkbox-label">[<?= $key['server_id'] ?>] <?= action_text_clear($key['server_name']) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <div class="input_container">
                                    <div class="input_form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?> <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNullText') ?>
                                        </div>
                                    </div>
                                    <div class="input_wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="server_id" placeholder="1" value="<?= $key_edit['server_id'] ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveIzm') ?>">
                    </div>
                </form>
            <?php endif; ?>
        </div>
<?php break;
endswitch; ?>