<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
        <svg viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
            <div class="container_text_settings_text">
                <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListAccess') ?></span>
                <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListAccessDesc') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h411 scroll">
                <div class="flex_table_proff">
                    <?php foreach ($Access as $access) : ?>
                        <div class="user_card_bg">
                            <div class="user_flex_av_nn">
                                <?php $General->get_js_relevance_avatar($access['steamid_access'], 1) ?>
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= $access['steamid_access'] ?>/?search=1"><img class="avatar_img" id="<?php if ($General->arr_general['theme'] == 'neo') { echo 'avatar'; } else { echo $access['steamid_access']; } ?>" <?php if ($General->arr_general['theme'] == 'neo') { echo 'avatarid="' . $access['steamid_access'] .'"'; } ?><?= $sz_i < '20' ? 'src' : 'data-src' ?>="<?= $General->getAvatar($access['steamid_access'], 1) ?>" title="" alt=""></a>
                                <div class="info_nn_vip">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSProff') ?>"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"></path></svg></div>
                                    <a class="info_a" href="<?= $General->arr_general['site'] ?>profiles/<?= $access['steamid_access'] ?>/?search=1"><?= empty($General->checkName($access['steamid_access'])) ? $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNN') : htmlspecialchars(action_text_trim($General->checkName($access['steamid_access']), 30)) ?></a>
                                </div>
                                <?php if ($Core->GetCache('settings')['restriction_access'] == 1) : else: ?>
                                    <a class="btn_req" href="<?= set_url_section(get_url(2), 'ms_access_edit', $access['id']) ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAcces') ?>" data-tippy-placement="top">
                                        <svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>
                                    <button class="btn_del" id="ms_access_del" id_del="<?= $access['steamid_access'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAccess') ?>" data-tippy-placement="top">
                                        <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                    </button>
                                <?php endif; ?>
                                <?php if ($Core->GetCache('settings')['restriction_access'] == 0) : elseif (isset($_SESSION['user_admin'])) : ?>
                                    <a class="btn_req" href="<?= set_url_section(get_url(2), 'ms_access_edit', $access['id']) ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditAcces') ?>" data-tippy-placement="top">
                                        <svg viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>
                                    <button class="btn_del" id="ms_access_del" id_del="<?= $access['steamid_access'] ?>" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelAccess') ?>" data-tippy-placement="top">
                                        <svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div class="user_flex_av_nn access_block">
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAddAdd') ?>"><svg viewBox="0 0 512 512"><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg></div>
                                    <span><?php if ($access['add_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAddAdmin') ?>"><svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"/></svg></div>
                                    <span><?php if ($access['add_admin_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostPred') ?>"><svg viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path></svg></div>
                                    <span><?php if ($access['add_warn_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostOnlie') ?>"><svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg></div>
                                    <span><?php if ($access['add_timecheck_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAddBan') ?>"><svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"></path></svg></div>
                                    <span><?php if ($access['add_ban_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <div class="info_access6">
                                    <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAddMute') ?>"><svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z"></path></svg></div>
                                    <span><?php if ($access['add_mute_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                </div>
                                <?php if (!empty($Db->db_data['Vips'])) : ?>
                                    <div class="info_access6">
                                        <div class="svg_div" data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAddVip') ?>"><svg viewBox="0 0 576 512"><path d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"/></svg></div>
                                        <span><?php if ($access['add_vip_access'] == 1) { echo '<svg viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>'; } else { echo '<svg viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>'; } ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <?php if (empty($_GET['ms_access_edit'])) : ?>
        <form id="ms_access_add">
            <div class="container_text_access2">
            <svg viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H392.6c-5.4-9.4-8.6-20.3-8.6-32V352c0-2.1 .1-4.2 .3-6.3c-31-26-71-41.7-114.6-41.7H178.3zM528 240c17.7 0 32 14.3 32 32v48H496V272c0-17.7 14.3-32 32-32zm-80 32v48c-17.7 0-32 14.3-32 32V480c0 17.7 14.3 32 32 32H608c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32V272c0-44.2-35.8-80-80-80s-80 35.8-80 80z"/></svg>
                <div class="container_text_settings_text">
                    <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAccess') ?></span>
                    <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddAccess') ?></span>
                </div>
            </div>
            <div class="card_settings">
                <div class="h411_max scroll">
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"/></svg>
                                STEAMID
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="steam_access" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." required>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessAddAccess') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access" id="access1" value="1" checked>
                                <label for="access1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access" id="access0" value="0">
                                <label for="access0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessAdmin') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_admin" id="access_admin1" value="1" checked>
                                <label for="access_admin1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_admin" id="access_admin0" value="0">
                                <label for="access_admin0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostPred') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_warn" id="access_warn1" value="1" checked>
                                <label for="access_warn1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_warn" id="access_warn0" value="0">
                                <label for="access_warn0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['AdminReward'])) : ?>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostOnlie') ?>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_timecheck" id="access_timecheck1" value="1" checked>
                                    <label for="access_timecheck1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_timecheck" id="access_timecheck0" value="0">
                                    <label for="access_timecheck0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessBan') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_ban" id="access_ban1" value="1" checked>
                                <label for="access_ban1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_ban" id="access_ban0" value="0">
                                <label for="access_ban0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessMute') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_mute" id="access_mute1" value="1" checked>
                                <label for="access_mute1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_mute" id="access_mute0" value="0">
                                <label for="access_mute0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['Vips'])) : ?>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessVip') ?>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_vip" id="access_vip1" value="1" checked>
                                    <label for="access_vip1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_vip" id="access_vip0" value="0">
                                    <label for="access_vip0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAccess') ?>">
            </div>
        </form>
    <?php endif; ?>
    <?php if (!empty($_GET['ms_access_edit'])) : $key_edit = $Core->SettingsCore()->Access_Info_Get($_GET['ms_access_edit']); ?>
        <form id="ms_access_edit">
            <div class="container_text_access2">
            <svg viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H392.6c-5.4-9.4-8.6-20.3-8.6-32V352c0-2.1 .1-4.2 .3-6.3c-31-26-71-41.7-114.6-41.7H178.3zM528 240c17.7 0 32 14.3 32 32v48H496V272c0-17.7 14.3-32 32-32zm-80 32v48c-17.7 0-32 14.3-32 32V480c0 17.7 14.3 32 32 32H608c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32V272c0-44.2-35.8-80-80-80s-80 35.8-80 80z"/></svg>
                <div class="container_text_settings_text">
                    <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditDostup') ?></span>
                    <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSEditDostupDesc') ?></span>
                </div>
            </div>
            <div class="card_settings">
                <div class="h411_max scroll">
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 496 512"><path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.8 52.8 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3 .1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"/></svg>
                                STEAMID
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSteamFinder') ?>" data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="steam_access" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/..." value="<?= $key_edit['steamid_access'] ?>" required>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessAddAccess') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access" id="access1" value="1" <?php if ($key_edit['add_access'] == 1) { echo 'checked'; } ?>>
                                <label for="access1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access" id="access0" value="0" <?php if ($key_edit['add_access'] == 0) { echo 'checked'; } ?>>
                                <label for="access0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessAdmin') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_admin" id="access_admin1" value="1" <?php if ($key_edit['add_admin_access'] == 1) { echo 'checked'; } ?>>
                                <label for="access_admin1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_admin" id="access_admin0" value="0" <?php if ($key_edit['add_admin_access'] == 0) { echo 'checked'; } ?>>
                                <label for="access_admin0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostPred') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_warn" id="access_warn1" value="1" <?php if ($key_edit['add_warn_access'] == 1) { echo 'checked'; } ?>>
                                <label for="access_warn1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_warn" id="access_warn0" value="0" <?php if ($key_edit['add_warn_access'] == 0) { echo 'checked'; } ?>>
                                <label for="access_warn0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['AdminReward'])) : ?>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDostOnlie') ?>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_timecheck" id="access_timecheck1" value="1" <?php if ($key_edit['add_timecheck_access'] == 1) { echo 'checked'; } ?>>
                                    <label for="access_timecheck1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_timecheck" id="access_timecheck0" value="0" <?php if ($key_edit['add_timecheck_access'] == 0) { echo 'checked'; } ?>>
                                    <label for="access_timecheck0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessBan') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_ban" id="access_ban1" value="1" <?php if ($key_edit['add_ban_access'] == 1) { echo 'checked'; } ?>>
                                <label for="access_ban1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_ban" id="access_ban0" value="0" <?php if ($key_edit['add_ban_access'] == 0) { echo 'checked'; } ?>>
                                <label for="access_ban0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessMute') ?>
                        </div>
                        <div class="card_button_flex">
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_mute" id="access_mute1" value="1" <?php if ($key_edit['add_mute_access'] == 1) { echo 'checked'; } ?>>
                                <label for="access_mute1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                            </div>
                            <div class="check_button_card">
                                <input class="radio__input" type="radio" name="access_mute" id="access_mute0" value="0" <?php if ($key_edit['add_mute_access'] == 0) { echo 'checked'; } ?>>
                                <label for="access_mute0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($Db->db_data['Vips'])) : ?>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccessVip') ?>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_vip" id="access_vip1" value="1" <?php if ($key_edit['add_vip_access'] == 1) { echo 'checked'; } ?>>
                                    <label for="access_vip1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYes') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="access_vip" id="access_vip0" value="0" <?php if ($key_edit['add_vip_access'] == 0) { echo 'checked'; } ?>>
                                    <label for="access_vip0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNo') ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSaveIzm') ?>">
            </div>
        </form>
    <?php endif; ?>
</div>