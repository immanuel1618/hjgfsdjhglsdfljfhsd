<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
            <svg viewBox="0 0 640 512">
                <path
                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipList') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListDesc') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <input class="input_search" name="search" id="search_table_vip"
                placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPoisk') ?>">
            <div class="h346 scroll">
                <div class="user_container_grid" id="table_result"></div>
                <div id="table_result_error"></div>
                <div class="user_container_grid" id="table_list_foreach">
                    <?php foreach ($VipUser as $key): ?>
                        <div class="user_card_bg">
                            <div class="user_flex_av_nn">
                                <?php $General->get_js_relevance_avatar(con_steam3to64_int($key['account_id']), 1) ?>
                                <a href="/profiles/<?= con_steam3to64_int($key['account_id']) ?>/?search=1"><img
                                        class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') { echo 'avatar'; } else { echo con_steam3to64_int($key['account_id']); } ?>" <?php if ($General->arr_general['theme'] == 'neo') { echo 'avatarid="' . con_steam3to64_int($key['account_id']) .'"'; } ?>
                                        src="<?= $General->getAvatar(con_steam3to64_int($key['account_id']), 1) ?>" title=""
                                        alt=""></a>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>">
                                        <svg viewBox="0 0 576 512">
                                            <path
                                                d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z">
                                            </path>
                                        </svg></div>
                                    <a class="info_a"
                                        href="/profiles/<?= con_steam3to64_int($key['account_id']) ?>/?search=1"><?= empty($General->checkName($key['account_id'])) ? htmlspecialchars(action_text_trim($key['name'], 30)) : htmlspecialchars(action_text_trim($General->checkName($key['account_id']), 30)) ?></a>
                                </div>
                                <a class="btn_req"
                                    href="<?= set_url_section(get_url(2), 'ms_vip_edit', $key['account_id']) ?>&sid=<?= $key['sid'] ?>"
                                    data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSREdVip') ?>"
                                    data-tippy-placement="top">
                                    <svg viewBox="0 0 512 512">
                                        <path
                                            d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                    </svg>
                                </a>
                                <button class="btn_del" id="ms_vip_del" id_del="<?= $key['account_id'] ?>"
                                    id_end="<?= $key['sid'] ?>"
                                    data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDElVip') ?>"
                                    data-tippy-placement="top">
                                    <svg viewBox="0 0 448 512">
                                        <path
                                            d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="user_flex_av_nn">
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGRoup') ?>">
                                        <svg viewBox="0 0 576 512">
                                            <path
                                                d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z">
                                            </path>
                                        </svg></div>
                                    <span
                                        class="info_span"><?= htmlspecialchars(action_text_trim($key['group'], 20)) ?></span>
                                </div>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?>">
                                        <svg viewBox="0 0 512 512">
                                            <path
                                                d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z">
                                            </path>
                                        </svg></div>
                                    <span class="info_span"><?= $key['sid'] ?></span>
                                </div>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top"
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstec') ?>">
                                        <svg viewBox="0 0 512 512">
                                            <path
                                                d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                                            </path>
                                        </svg></div>
                                    <span
                                        class="info_span"><?php if (empty($key['expires'])) {
                                            echo $Translate->get_translate_phrase('_Forever');
                                        } elseif ($key['expires'] < time()) {
                                            echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecaet');
                                        } else {
                                            echo $Core->action_time_exchange_exact($key['expires'] - time());
                                        } ?></span>
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
    <?php if (empty($_GET['ms_vip_edit']) && empty($_GET['sid'])): ?>
        <form id="ms_vip_add">
            <div class="container_text_access2">
                <svg viewBox="0 0 576 512">
                    <path
                        d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z">
                    </path>
                </svg>
                <div class="container_text_settings_text">
                    <span
                        class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddVip') ?></span>
                    <span
                        class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormDescAdd') ?></span>
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
                            <input type="text" name="account_id"
                                placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..."
                                required>
                        </div>
                    </div>
                    <?php if ($Core->GetCache('settings')['group_choice_vip'] == 1): ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 576 512">
                                        <path
                                            d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovVipGroup') ?>
                                </div>
                            </div>
                            <?php if (!empty($Core->GetCache('vipgroup'))): ?>
                                <div class="card_button_flex_more">
                                    <?php foreach ($Core->GetCache('vipgroup') as $key): ?>
                                        <div class="check_button_card">
                                            <input class="radio__input" type="radio" name="group_choice_vip"
                                                id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                            <label for="group_choice<?= $key['id'] ?>"
                                                class="custom-radio"><?= action_text_trim($key['name_group'], 15) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoVipGroup') ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 576 512">
                                        <path
                                            d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipGroup') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span
                                    data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGFRoupConf') ?>"
                                    data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path
                                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="text" name="group"
                                    placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1') ?>"
                                    required>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($Core->GetCache('settings')['time_choice_privileges'] == 1): ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path
                                            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovTime') ?>
                                </div>
                            </div>
                            <?php if (!empty($Core->GetCache('privilegestime'))): ?>
                                <div class="card_button_flex_more">
                                    <?php foreach ($Core->GetCache('privilegestime') as $key): ?>
                                        <div class="check_button_card">
                                            <input class="radio__input" type="radio" name="time_choice_privileges"
                                                id="time_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>">
                                            <label for="time_choice<?= $key['id'] ?>"
                                                class="custom-radio"><?= action_text_trim($key['name_time'], 15) ?></label>
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
                                        <path
                                            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSov') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                    <div class="number">
                                    <?php endif; ?>
                                    <span
                                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>"
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
                                        <input type="number" min="0" name="expires" placeholder="30">
                                        <button class="number-plus" type="button"
                                            onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                    <?php else: ?>
                                        <input type="number" min="0" name="expires" placeholder="30">
                                    <?php endif; ?>
                                    <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDayTime') ?>
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                <div class="number">
                                <?php endif; ?>
                                <span
                                    data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>"
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
                                    <input type="number" min="0" name="expires" placeholder="30" required>
                                    <button class="number-plus" type="button"
                                        onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                <?php else: ?>
                                    <input type="number" min="0" name="expires" placeholder="30" required>
                                <?php endif; ?>
                                <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($Core->GetCache('settings')['vip_one_table'] == 1 && !empty($Core->GetCache('serversvip'))): ?>
                <?php if ($sid == 'all'): ?>
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z">
                                    </path>
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?>
                            </div>
                        </div>
                        <div class="card_button_flex_more">
                            <?php foreach ($Core->GetCache('serversvip') as $key): ?>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="sid[]" id="sid<?= $key['server_id'] ?>"
                                        value="<?= $key['server_id'] ?>">
                                    <label for="sid<?= $key['server_id'] ?>" class="custom-radio">[<?= $key['server_id'] ?>]
                                        <?= action_text_trim($key['server_name'], 13) ?></label>
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
                                <path
                                    d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span
                            data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>"
                            data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                </path>
                            </svg>
                        </span>
                        <input type="text" name="sid" placeholder="1" required>
                    </div>
                </div>
            <?php endif ?>
    </div>
    <input class="secondary_btn w100" type="submit"
        value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddVip') ?>">
    </div>
    </form>
<?php endif; ?>
<?php if (!empty($_GET['ms_vip_edit']) && !empty($_GET['sid'])):
    $key_edit = $Core->VipCore()->Vip_Info_Get($_GET['ms_vip_edit'], $_GET['sid']); ?>
    <form id="ms_vip_edit">
        <div class="container_text_access2">
            <svg viewBox="0 0 576 512">
                <path
                    d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z">
                </path>
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditVip1') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormEditVip') ?></span>
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
                        <input type="text" name="account_id"
                            placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..."
                            value="[U:1:<?= $key_edit['account_id'] ?>]" required>
                    </div>
                </div>
                <?php if ($Core->GetCache('settings')['group_choice_vip'] == 1): ?>
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 576 512">
                                    <path
                                        d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGotovVipGroup') ?>
                            </div>
                        </div>
                        <div class="card_button_flex_more">
                            <?php if (!empty($Core->GetCache('vipgroup'))): ?>
                                <?php foreach ($Core->GetCache('vipgroup') as $key): ?>
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="group_choice_vip"
                                            id="group_choice<?= $key['id'] ?>" value="<?= $key['id'] ?>" <?php if ($key['name_group'] == $key_edit['group']) {
                                                    echo 'checked';
                                                } ?>>
                                        <label for="group_choice<?= $key['id'] ?>"
                                            class="custom-radio"><?= action_text_trim($key['name_group'], 15) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNoVipGroup') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 576 512">
                                    <path
                                        d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVipGroup') ?>
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSGFRoupConf') ?>"
                                data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" name="group"
                                placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup1') ?>"
                                value="<?= $key_edit['group'] ?>" required>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTimeSec2') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                    <?php if ($General->arr_general['theme'] == 'neo') : ?>
                                <div class="number">
                            <?php endif; ?>
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTim2') ?>"
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
                                        <input type="number" min="0" name="expires"
                                placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>"
                                value="<?php if ($key_edit['expires'] == 0) {
                                    echo $key_edit['expires'];
                                } else {
                                    echo (float) $key_edit['expires'] - time();
                                } ?>"
                                required>
                                    <button class="number-plus" type="button"
                                        onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                <?php else: ?>
                                    <input type="number" min="0" name="expires"
                                        placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>"
                                        value="<?php if ($key_edit['expires'] == 0) {
                                            echo $key_edit['expires'];
                                        } else {
                                            echo (float) $key_edit['expires'] - time();
                                        } ?>"
                                        required>
                                <?php endif; ?>
                                <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512">
                                <path
                                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                            </svg>
                            Добавить срок (в днях)
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <?php if ($General->arr_general['theme'] == 'neo'): ?>
                            <div class="number">
                            <?php endif; ?>
                            <span
                                data-tippy-content="Укажите количество дней, которое вы хотите добавить"
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
                                <input type="number" min="0" name="expires_plus" placeholder="30">
                                <button class="number-plus" type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                            <?php else: ?>
                                <input type="number" min="0" name="expires_plus" placeholder="30">
                            <?php endif; ?>
                            <?php if ($General->arr_general['theme'] == 'neo'): ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($Core->GetCache('settings')['vip_one_table'] == 1 && !empty($Core->GetCache('serversvip'))): ?>
                    <?php if ($sid == 'all'): ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path
                                            d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z">
                                        </path>
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?>
                                </div>
                            </div>
                            <div class="card_button_flex_more">
                                <?php foreach ($Core->GetCache('serversvip') as $key) : ?>
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="sid[]" id="sid<?= $key['server_id'] ?>" value="<?= $key['server_id'] ?>" <?php if ($key['server_id'] == $key_edit['sid']) { echo 'checked'; } ?>>
                                        <label for="sid<?= $key['server_id'] ?>" class="custom-radio">[<?= $key['server_id'] ?>] <?= action_text_trim($key['server_name'], 13) ?></label>
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
                                    <path
                                        d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServ') ?>
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSidVip') ?>"
                                data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" name="sid" placeholder="1" value="<?= $key_edit['sid'] ?>" required>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <input class="secondary_btn w100" type="submit"
                value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveIzm') ?>">
        </div>
    </form>
<?php endif; ?>
</div>