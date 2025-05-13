<?php switch ($res_system[$server_group]['admin_mod']):
    case 'AdminSystem': ?>
        <div class="container_grid">
            <div class="fix_grid">
                <div class="container_text_access">
                    <svg viewBox="0 0 640 512">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListNaacaz') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeadMuteDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <input class="input_search" name="search" id="search_table_mute" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
                    <div class="h346 scroll">
                        <div class="flex_table_proff" id="table_result"></div>
                        <div id="table_result_error"></div>
                        <div class="flex_table_proff" id="table_list_foreach">
                            <?php foreach ($MSMute as $key) : ?>
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
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z" />
                                                </svg></div>
                                            <a class="info_a" href="/profiles/<?= $key['steamid'] ?>/?search=1"><?= empty($General->checkName($key['steamid'])) ? action_text_clear($key['name']) : action_text_clear($General->checkName($key['steamid'])) ?></a>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512">
                                                    <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= $key['steamid'] ?></span>
                                        </div>
                                        <div class="info_nn addmute_none">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                                                </svg></div>
                                            <?php if (!empty($key['admin_steamid'])): ?>
                                                <a class="info_a" href="<?= $General->arr_general['site'] ?>profiles/<?= $key['admin_steamid'] ?>">
                                                    <?= empty($General->checkName($key['admin_steamid'])) ? action_text_clear($key['admin_name']) : action_text_clear($General->checkName($key['admin_steamid'])) ?>
                                                </a>
                                            <?php else: ?>
                                                <a class="info_a">
                                                    CONSOLE
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <button class="btn_req" id="ms_mute_unban" id_del="<?= $key['steamid'] ?>" id_end="<?= $key['id'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute2') ?>" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512">
                                                <path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z" />
                                            </svg>
                                        </button>
                                        <button class="btn_del" id="ms_mute_del" id_del="<?= $key['steamid'] ?>" id_end="<?= $key['id'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelMute') ?>" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512">
                                                <path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="user_flex_av_nn">
                                        <div class="info_deff_reason">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= htmlspecialchars(action_text_trim($key['reason'], 30)) ?></span>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php if ($key['expires'] == 0 && empty($key['unpunish_admin_id'])) {
                                                    echo $Translate->get_translate_phrase('_Forever');
                                                } elseif (!empty($key['unpunish_admin_id'])) {
                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                                } else {
                                                    if (time() > $key['expires']) {
                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                                    } else {
                                                        echo $Core->action_time_exchange_exact($key['expires'] - time());
                                                    }
                                                } ?>
                                            </span>
                                        </div>
                                        <div class="info_deff_reason addmute_none">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z" />
                                                </svg></div>
                                            <span class="info_span"><?= date('d.m.Y в H:i', $key['created']) ?></span>
                                        </div>
                                        <?php if ($key['punish_type'] == 3) {
                                            $punishmentType = '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat');
                                        } elseif ($key['punish_type'] == 2) {
                                            $punishmentType = '<svg viewBox="0 0 640 512"><path d="M64.03 239.1c0 49.59 21.38 94.1 56.97 130.7c-12.5 50.39-54.31 95.3-54.81 95.8c-2.187 2.297-2.781 5.703-1.5 8.703c1.312 3 4.125 4.797 7.312 4.797c66.31 0 116-31.8 140.6-51.41c32.72 12.31 69.02 19.41 107.4 19.41c37.39 0 72.78-6.663 104.8-18.36L82.93 161.7C70.81 185.9 64.03 212.3 64.03 239.1zM630.8 469.1l-118.1-92.59C551.1 340 576 292.4 576 240c0-114.9-114.6-207.1-255.1-207.1c-67.74 0-129.1 21.55-174.9 56.47L38.81 5.117C28.21-3.154 13.16-1.096 5.115 9.19C-3.072 19.63-1.249 34.72 9.188 42.89l591.1 463.1c10.5 8.203 25.57 6.333 33.7-4.073C643.1 492.4 641.2 477.3 630.8 469.1z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat');
                                        } elseif ($key['punish_type'] == 1) {
                                            $punishmentType = '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zM344 430.4c20.4-2.8 39.7-9.1 57.3-18.2l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro');
                                        } ?>
                                        <div class="info_access_type">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $punishmentType_tippy ?>"><?= $punishmentType ?></div>
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
            <form id="ms_mute_add">
                <div class="container_text_access2">
                    <svg viewBox="0 0 640 512">
                        <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z"></path>
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddMute') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddMute') ?></span>
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
                                <input type="text" name="steam_player" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." required>
                            </div>
                        </div>
                        <?php if ($Core->GetCache('settings')['time_choice_punishment'] == 1) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeChoose') ?>
                                    </div>
                                </div>
                                <?php if (!empty($Core->GetCache('punishmenttime'))) : ?>
                                    <div class="card_button_flex_more">
                                        <?php foreach ($Core->GetCache('punishmenttime') as $key) : ?>
                                            <div class="check_button_card">
                                                <input class="radio__input" type="radio" name="time_choice_punishment" id="time_choice_punishment<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                <label for="time_choice_punishment<?= $key['id'] ?>" class="custom-radio"><?= action_text_trim($key['name_time'], 15) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminTimeNo') ?>
                                <?php endif; ?>
                            </div>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSovDay') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MS0ForevTime') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>">
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>">
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
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNacazSec') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MS0ForevTime') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" required>
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" required>
                                        <?php endif; ?>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($Core->GetCache('settings')['reason_mute'] == 1) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovReaS') ?>
                                    </div>
                                </div>
                                <div class="card_button_flex_more_res">
                                    <?php foreach ($Core->GetCache('reasonmute') as $key) : ?>
                                        <div class="check_button_card">
                                            <input class="radio__input" type="radio" name="reason_mute" id="reason_mute<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                            <label for="reason_mute<?= $key['id'] ?>" class="custom-radio"><?= action_text_trim($key['reason_name'], 45) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasMute') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="reason_name" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonBanInput') ?>" required>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNacaz') ?>
                                </div>
                            </div>
                            <div class="card_button_flex_more_3">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment1" value="1">
                                    <label for="type_punishment1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment2" value="2">
                                    <label for="type_punishment2" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment3" value="3">
                                    <label for="type_punishment3" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAll') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNewMute') ?>">
                </div>
            </form>
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
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListNaacaz') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeadMuteDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <input class="input_search" name="search" id="search_table_mute" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
                    <div class="h346 scroll">
                        <div class="flex_table_proff" id="table_result"></div>
                        <div id="table_result_error"></div>
                        <div class="flex_table_proff" id="table_list_foreach">
                            <?php foreach ($MSMute as $key) : ?>
                                <div class="user_card_bg">
                                    <div class="user_flex_av_nn">
                                        <?php $General->get_js_relevance_avatar($key['steam_id'], 1) ?>
                                        <a href="/profiles/<?= $key['steam_id'] ?>/?search=1"><img class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                echo 'avatar';
                                                                                                                            } else {
                                                                                                                                echo $key['steam_id'];
                                                                                                                            } ?>" <?php if ($General->arr_general['theme'] == 'neo') {
                                                                                                                                        echo 'avatarid="' . $key['steam_id'] . '"';
                                                                                                                                    } ?> src="<?= $General->getAvatar($key['steam_id'], 1) ?>" title="" alt=""></a>
                                        <div class="info_nn">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNarush') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M352 493.4c-29.6 12-62.1 18.6-96 18.6s-66.4-6.6-96-18.6V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V477.8C51.5 433.5 0 350.8 0 256C0 114.6 114.6 0 256 0S512 114.6 512 256c0 94.8-51.5 177.5-128 221.8V288c0-8.8-7.2-16-16-16s-16 7.2-16 16V493.4zM195.2 233.6c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2c17.6-23.5 52.8-23.5 70.4 0zm121.6 0c17.6-23.5 52.8-23.5 70.4 0c5.3 7.1 15.3 8.5 22.4 3.2s8.5-15.3 3.2-22.4c-30.4-40.5-91.2-40.5-121.6 0c-5.3 7.1-3.9 17.1 3.2 22.4s17.1 3.9 22.4-3.2zM208 336v32c0 26.5 21.5 48 48 48s48-21.5 48-48V336c0-26.5-21.5-48-48-48s-48 21.5-48 48z" />
                                                </svg></div>
                                            <a class="info_a" href="/profiles/<?= $key['steam_id'] ?>/?search=1"><?= empty($General->checkName($key['steam_id'])) ? action_text_clear($key['name']) : action_text_clear($General->checkName($key['steam_id'])) ?></a>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg viewBox="0 0 496 512">
                                                    <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= $key['steam_id'] ?></span>
                                        </div>
                                        <div class="info_nn addmute_none">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmin') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path>
                                                </svg></div>
                                            <?php if (!empty($key['admin_steamid']) && $key['admin_steamid'] != "CONSOLE"): ?>
                                                <a class="info_a" href="<?= $General->arr_general['site'] ?>profiles/<?= $key['admin_steamid'] ?>">
                                                    <?= empty($General->checkName($key['admin_steamid'])) ? action_text_clear($key['admin_name']) : action_text_clear($General->checkName($key['admin_steamid'])) ?>
                                                </a>
                                            <?php else: ?>
                                                <a class="info_a">
                                                    CONSOLE
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <button class="btn_req" id="ms_mute_unban" id_del="<?= $key['steam_id'] ?>" id_end="<?= $key['id'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnMute2') ?>" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512">
                                                <path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z" />
                                            </svg>
                                        </button>
                                        <button class="btn_del" id="ms_mute_del" id_del="<?= $key['steam_id'] ?>" id_end="<?= $key['id'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelMute') ?>" data-tippy-placement="top">
                                            <svg viewBox="0 0 448 512">
                                                <path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="user_flex_av_nn">
                                        <div class="info_deff_reason">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd') ?>"><svg viewBox="0 0 512 512">
                                                    <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                </svg></div>
                                            <span class="info_span"><?= htmlspecialchars(action_text_trim($key['reason'], 30)) ?></span>
                                        </div>
                                        <div class="info_deff">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>">
                                                <svg viewBox="0 0 512 512">
                                                    <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                                                </svg>
                                            </div>
                                            <span class="info_span">
                                                <?php if ($key['end_at'] == 0 && empty($key['unbanned_by'])) {
                                                    echo $Translate->get_translate_phrase('_Forever');
                                                } elseif (!empty($key['unbanned_by'])) {
                                                    echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSUnban2');
                                                } else {
                                                    if (time() > $key['end_at']) {
                                                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                                    } else {
                                                        echo $Core->action_time_exchange_exact($key['end_at'] - time());
                                                    }
                                                } ?>
                                            </span>
                                        </div>
                                        <div class="info_deff_reason addmute_none">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh') ?>"><svg viewBox="0 0 448 512">
                                                    <path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z" />
                                                </svg></div>
                                            <span class="info_span"><?= date('d.m.Y в H:i', $key['created_at']) ?></span>
                                        </div>
                                        <?php if ($key['mute_type'] == 2) {
                                            $punishmentType = '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicroChat');
                                        } elseif ($key['mute_type'] == 1) {
                                            $punishmentType = '<svg viewBox="0 0 640 512"><path d="M64.03 239.1c0 49.59 21.38 94.1 56.97 130.7c-12.5 50.39-54.31 95.3-54.81 95.8c-2.187 2.297-2.781 5.703-1.5 8.703c1.312 3 4.125 4.797 7.312 4.797c66.31 0 116-31.8 140.6-51.41c32.72 12.31 69.02 19.41 107.4 19.41c37.39 0 72.78-6.663 104.8-18.36L82.93 161.7C70.81 185.9 64.03 212.3 64.03 239.1zM630.8 469.1l-118.1-92.59C551.1 340 576 292.4 576 240c0-114.9-114.6-207.1-255.1-207.1c-67.74 0-129.1 21.55-174.9 56.47L38.81 5.117C28.21-3.154 13.16-1.096 5.115 9.19C-3.072 19.63-1.249 34.72 9.188 42.89l591.1 463.1c10.5 8.203 25.57 6.333 33.7-4.073C643.1 492.4 641.2 477.3 630.8 469.1z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat');
                                        } elseif ($key['mute_type'] == 0) {
                                            $punishmentType = '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zM344 430.4c20.4-2.8 39.7-9.1 57.3-18.2l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4z"></path></svg>';
                                            $punishmentType_tippy = $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro');
                                        } ?>
                                        <div class="info_access_type">
                                            <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $punishmentType_tippy ?>"><?= $punishmentType ?></div>
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
            <form id="ms_mute_add">
                <div class="container_text_access2">
                    <svg viewBox="0 0 640 512">
                        <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z"></path>
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddMute') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddMute') ?></span>
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
                                <input type="text" name="steam_player" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." required>
                            </div>
                        </div>
                        <?php if ($Core->GetCache('settings')['time_choice_punishment'] == 1) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeChoose') ?>
                                    </div>
                                </div>
                                <?php if (!empty($Core->GetCache('punishmenttime'))) : ?>
                                    <div class="card_button_flex_more">
                                        <?php foreach ($Core->GetCache('punishmenttime') as $key) : ?>
                                            <div class="check_button_card">
                                                <input class="radio__input" type="radio" name="time_choice_punishment" id="time_choice_punishment<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                                <label for="time_choice_punishment<?= $key['id'] ?>" class="custom-radio"><?= action_text_trim($key['name_time'], 15) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdminTimeNo') ?>
                                <?php endif; ?>
                            </div>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSovDay') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MS0ForevTime') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>">
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>">
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
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeNacazSec') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        <div class="number">
                                        <?php endif; ?>
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MS0ForevTime') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                            </svg>
                                        </span>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" required>
                                            <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                        <?php else : ?>
                                            <input type="number" min="0" name="duration" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>" required>
                                        <?php endif; ?>
                                        <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($Core->GetCache('settings')['reason_mute'] == 1) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovReaS') ?>
                                    </div>
                                </div>
                                <div class="card_button_flex_more_res">
                                    <?php foreach ($Core->GetCache('reasonmute') as $key) : ?>
                                        <div class="check_button_card">
                                            <input class="radio__input" type="radio" name="reason_mute" id="reason_mute<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                            <label for="reason_mute<?= $key['id'] ?>" class="custom-radio"><?= action_text_trim($key['reason_name'], 45) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z" />
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasMute') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="reason_name" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonBanInput') ?>" required>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTypeNacaz') ?>
                                </div>
                            </div>
                            <div class="card_button_flex_more_3">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment1" value="1">
                                    <label for="type_punishment1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSMicro') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment2" value="2">
                                    <label for="type_punishment2" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSChat') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="type_punishment" id="type_punishment3" value="3">
                                    <label for="type_punishment3" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAll') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNewMute') ?>">
                </div>
            </form>
        </div>
<?php break;
endswitch; ?>