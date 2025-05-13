<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
            <svg viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
            <div class="container_text_settings_text">
                <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline1') ?></span>
                <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline2') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <input class="input_search" name="search" id="search_table_ar" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
            <div class="h346 scroll">
                <div class="user_container_grid" id="table_result"></div>
                <div id="table_result_error"></div>
                <div class="user_container_grid" id="table_list_foreach">
                    <?php foreach ($ARAdminInfoTime as $key) : ?>
                        <div class="user_card_bg">
                            <div class="user_flex_av_nn">
                                <?php $General->get_js_relevance_avatar($key['steamid'], 1) ?>
                                <a href="/profiles/<?= con_steam32to64($key['steamid']) ?>/?search=1"><img class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') { echo 'avatar'; } else { echo con_steam32to64($key['steamid']); } ?>" <?php if ($General->arr_general['theme'] == 'neo') { echo 'avatarid="' . con_steam32to64($key['steamid']) .'"'; } ?> src="<?= $General->getAvatar(con_steam32to64($key['steamid']), 1) ?>" title="" alt=""></a>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                    <a class="info_a" href="<?= $General->arr_general['site'] ?>profiles/<?= con_steam32to64($key['steamid']) ?>/?search=1"><?= empty($General->checkName(con_steam32to64($key['steamid']))) ? $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : action_text_trim($General->checkName(con_steam32to64($key['steamid'])), 30)?></a>
                                </div>
                                <?php $isAdmin = false; foreach ($Access as $admin) { if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_access'] == 1) { $isAdmin = true; } } if (isset($_SESSION['user_admin'])) { $isAdmin = true; } ?>
                                <?php if ($isAdmin) : ?>
                                    <button class="btn_del" id="ms_ar_del" id_del="<?= $key['steamid'] ?>"
                                        data-tippy-content="Очистить онлайн"
                                        data-tippy-placement="top">
                                        <svg viewBox="0 0 448 512">
                                            <path
                                                d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z">
                                            </path>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div class="user_flex_av_nn">
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline8') ?>"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg></div>
                                    <span class="info_span"><?= $Core->action_time_exchange_exact($key['total_time']) ?></span>
                                </div>
                                <div class="info_deff">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline9') ?>"><svg viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg></div>
                                    <span class="info_span"><?= date('d.m.Y', $key['newest_date']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="pagination">
            <?php if($page_num != 1): ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512"><path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path></svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512"><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path></svg></a>
            <?php endif; ?>
            <?php if($page_max < 5): for($i = 1; $i <= $page_max; $i++): ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
            <?php endfor; else: for($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++): ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
            <?php endfor; endif; ?>
            <?php if($page_num != $page_max): ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512"><path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path></svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512"><path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path></svg></a>
            <?php endif; ?>
        </div>
    </div>
    <form>
        <div class="container_text_access2">
            <svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg>
            <div class="container_text_settings_text">
                <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline3') ?></span>
                <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline4') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h411_max scroll">
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline5') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                            </svg>
                        </span>
                        <input type="date" name="start_date" value="<?php if (isset($_GET['start_date'])) { echo $_GET['start_date']; } else { foreach ($ARMinData as $entry) { echo $entry['min_date']; } } ?>" required>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline6') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                            </svg>
                        </span>
                        <input type="date" name="end_date" value="<?php if (isset($_GET['end_date'])) { echo $_GET['end_date']; } else { echo date('Y-m-d'); }?>" required>
                    </div>
                </div>
            </div>
            <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnline7') ?>">
        </div>
    </form>
</div>