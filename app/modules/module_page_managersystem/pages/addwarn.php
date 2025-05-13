<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
            <svg viewBox="0 0 512 512">
                <path
                    d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z">
                </path>
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListPred') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListPredDesc') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h346 scroll">
                <div class="flex_table_proff">
                    <?php foreach ($Core->AdminCore()->Warn() as $key): ?>
                        <div class="user_card_bg">
                            <div class="user_flex_av_nn">
                                <?php if (!empty($General->arr_general['avatars'])): ?>
                                    <a
                                        href="<?= $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64($key['steamid']) : $key['steamid'] ?>/?search=1"><img
                                            class="avatar_img"
                                            id="<?php if ($General->arr_general['theme'] == 'neo') { echo 'avatar'; } else { echo $key['steamid']; } ?>" <?php if ($General->arr_general['theme'] == 'neo') { echo 'avatarid="' . $key['steamid'] .'"'; } ?>
                                            <?= $sz_i < '20' ? 'src' : 'data-src' ?>="<?= $General->getAvatar(con_steam32to64($key['steamid']), 1) ?>" title=""
                                            alt=""></a>
                                <?php endif; ?>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>">
                                        <svg viewBox="0 0 448 512">
                                            <path
                                                d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z">
                                            </path>
                                        </svg></div>
                                    <a class="info_a"
                                        href="<?= $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64($key['steamid']) : $key['steamid'] ?>/?search=1"><?= empty($General->checkName($key['steamid'])) ? $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : action_text_trim($General->checkName($key['steamid']), 30) ?></a>
                                </div>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="STEAMID"><svg
                                            viewBox="0 0 496 512">
                                            <path
                                                d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z">
                                            </path>
                                        </svg></div>
                                    <span class="info_span"><?= $key['steamid'] ?></span>
                                </div>
                                <button class="btn_del" id="ms_warn_del" id_del="<?= $key['steamid'] ?>"
                                    id_end="<?= $key['id'] ?>"
                                    data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelPred1') ?>"
                                    data-tippy-placement="top">
                                    <svg viewBox="0 0 448 512">
                                        <path
                                            d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="user_flex_av_nn">
                                <div class="info_deff_reason">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd') ?>">
                                        <svg viewBox="0 0 512 512">
                                            <path
                                                d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z">
                                            </path>
                                        </svg></div>
                                    <span class="info_span"><?= action_text_trim($key['reason'], 30) ?></span>
                                </div>
                                <div class="info_deff">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>">
                                        <svg viewBox="0 0 512 512">
                                            <path
                                                d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                                            </path>
                                        </svg></div>
                                    <span
                                        class="info_span"><?php if ($key['time'] < time()) {
                                            echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                        } else {
                                            echo $Core->action_time_exchange_exact($key['time'] - time());
                                        } ?></span>
                                </div>
                                <div class="info_deff_time">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddNaruh') ?>">
                                        <svg viewBox="0 0 448 512">
                                            <path
                                                d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z" />
                                        </svg></div>
                                    <span class="info_span"><?= date('d.m.Y в H:i', $key['createtime']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="pagination">
            <?php if ($page_num != 1): ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg
                        viewBox="0 0 448 512">
                        <path
                            d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z">
                        </path>
                    </svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg
                        viewBox="0 0 384 512">
                        <path
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z">
                        </path>
                    </svg></a>
            <?php endif; ?>
            <?php if ($page_max < 5):
                for ($i = 1; $i <= $page_max; $i++): ?>
                    <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                <?php endfor; else:
                for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++): ?>
                    <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                <?php endfor; endif; ?>
            <?php if ($page_num != $page_max): ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg
                        viewBox="0 0 384 512">
                        <path
                            d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                        </path>
                    </svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg
                        viewBox="0 0 448 512">
                        <path
                            d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z">
                        </path>
                    </svg></a>
            <?php endif; ?>
        </div>
    </div>
    <form id="ms_warn_add">
        <div class="container_text_access2">
            <svg viewBox="0 0 512 512">
                <path
                    d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z">
                </path>
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddPred2') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddPred2') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h411_max scroll">
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 496 512">
                                <path
                                    d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                            </svg>
                            STEAMID
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span
                            data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>"
                            data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                </path>
                            </svg>
                        </span>
                        <input type="text" name="steamid"
                            placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..."
                            required>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span
                            data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred1') ?>"
                            data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                </path>
                            </svg>
                        </span>
                        <input type="text" name="reason"
                            placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred2') ?>"
                            required>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred3') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <?php if ($General->arr_general['theme'] == 'neo'): ?>
                            <div class="number">
                            <?php endif; ?>
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred4') ?>"
                                data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                    </path>
                                </svg>
                            </span>
                            <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                <button class="number-minus" type="button"
                                    onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                <input type="number" min="0" name="time" placeholder="30" required>
                                <button class="number-plus" type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                            <?php else: ?>
                                <input type="number" min="0" name="time" placeholder="30" required>
                            <?php endif; ?>
                            <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <input class="secondary_btn w100" type="submit"
                value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSResPred5') ?>">
        </div>
    </form>
</div>