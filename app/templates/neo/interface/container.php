<?php $settings_neo = $General->get_neo_options(); ?>
<div class="navbar row">
    <!-- navigation -->
    <div class="navbar_menu_left">
        <!-- PC menu  -->
        <div class="drpdwn_menu">
        <?php $menu_points = $General->get_neo_menu(); $menu_categories = $General->get_neo_menu_categories();
        $combined_menu = [];
        foreach ($menu_categories as $category) {
            $category['is_category'] = true;
            $combined_menu[] = $category;
        }

        foreach ($menu_points as $menu_point) {
            $menu_point['is_category'] = false;
            $combined_menu[] = $menu_point;
        }
        usort($combined_menu, function ($a, $b) {
            return $a['sort'] <=> $b['sort'];
        });
        $current_route = $Modules->route;
        foreach ($combined_menu as $item) :
            if ($item['is_category']) :
                $category_id = $item['numid'];
                $menu_items = array_filter($combined_menu, function($menu_item) use ($category_id) {
                    return !$menu_item['is_category'] && $menu_item['category'] == $category_id;
                });
                usort($menu_items, function ($a, $b) {
                    return $a['sort_category'] <=> $b['sort_category'];
                });
                $is_active_category = false;
                foreach ($menu_items as $menu_item) {
                    if ($current_route == substr($menu_item['link'], 1)) {
                        $is_active_category = true;
                        break;
                    }
                } ?>
                <div class="dropdown">
                    <?php if (empty($item['only_admin']) || (!empty($item['only_admin']) && isset($_SESSION['user_admin']))) : ?>
                        <a class="dropbtn<?= $is_active_category ? ' active_btn' : ''; ?>">
                            <?= $item['svg']; ?>
                            <span class="desc_nav_item"><?= $item['title']; ?></span>
                        </a>
                    <?php endif; ?>
                    <div class="dropdown_block">
                        <?php foreach ($menu_items as $menu_item) : ?>
                            <?php if (empty($menu_item['only_admin']) || (!empty($menu_item['only_admin']) && isset($_SESSION['user_admin']))) : ?>
                                <a href="<?= $menu_item['link']; ?>" class="<?= ($current_route == substr($menu_item['link'], 1)) ? 'active_btn' : ''; ?>">
                                    <div class="dropdown_item">
                                        <?= $menu_item['svg']; ?>
                                        <div>
                                            <h4><?= $menu_item['title']; ?></h4>
                                            <?php empty($menu_item['description']) ? '' : print '<p>' . $menu_item['description'] . '</p>' ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: 
                if (empty($item['category'])) : ?>
                    <div class="dropdown">
                        <?php if (empty($item['only_admin']) || (!empty($item['only_admin']) && isset($_SESSION['user_admin']))) : ?>
                            <a href="<?= $item['link']; ?>" class="dropbtn<?= ($current_route == substr($item['link'], 1)) ? ' active_btn' : ''; ?>">
                                <?= $item['svg']; ?>
                                <span class="desc_nav_item"><?= $item['title']; ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif;
            endif;
        endforeach; ?>
        </div>
        <!-- Mobile menu -->
        <div class="header_burger">
            <span></span>
        </div>
        <div class="nav_header_menu no_scroll">
            <ul class="header_list">
                <?php foreach ($menu_points as $key) : if (empty($key['only_admin']) || (!empty($key['only_admin']) && isset($_SESSION['user_admin']))) : ?>
                        <a href="<?= $key['link']; ?>">
                            <li>
                                <?= $key['title']; ?>
                            </li>
                        </a>
                <?php endif;
                endforeach; ?>
            </ul>
        </div>
    </div>
    <!-- Userbar menu -->
    <div class="navbar_usermenu">
        <?php if (!empty($Db->db_data['lk'])) : ?>
            <div class="secondary_btn pay_button" data-openmodal="popupPay">
                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M5 15c-2.21 0-4 1.79-4 4 0 .75.21 1.46.58 2.06C2.27 22.22 3.54 23 5 23s2.73-.78 3.42-1.94c.37-.6.58-1.31.58-2.06 0-2.21-1.79-4-4-4zm1.49 4.73h-.74v.78c0 .41-.34.75-.75.75s-.75-.34-.75-.75v-.78h-.74c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h.74v-.71c0-.41.34-.75.75-.75s.75.34.75.75v.71h.74a.749.749 0 1 1 0 1.5zM21.5 12.5H19c-1.1 0-2 .9-2 2s.9 2 2 2h2.5c.28 0 .5-.22.5-.5v-3c0-.28-.22-.5-.5-.5zM16.53 5.4c.3.29.05.74-.37.74l-8.28-.01c-.48 0-.72-.58-.38-.92l1.75-1.76a3.796 3.796 0 0 1 5.35 0l1.89 1.91.04.04z"></path>
                            <path d="M21.87 18.66C21.26 20.72 19.5 22 17.1 22h-6.5c-.39 0-.64-.43-.48-.79.3-.7.49-1.49.49-2.21 0-3.03-2.47-5.5-5.5-5.5-.76 0-1.5.16-2.18.46-.37.16-.82-.09-.82-.49V12c0-2.72 1.64-4.62 4.19-4.94.25-.04.52-.06.8-.06h10c.26 0 .51.01.75.05 2.02.23 3.48 1.46 4.02 3.29.1.33-.14.66-.48.66H19.1c-2.17 0-3.89 1.98-3.42 4.23.33 1.64 1.85 2.77 3.52 2.77h2.19c.35 0 .58.34.48.66z"></path>
                        </g>
                    </g>
                </svg>
                <span class="hide_balance_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ButtonPay') ?></span>
            </div>
        <?php endif; ?>
        <!-- User notification -->
        <?php if (!empty($_SESSION['steamid'])) : ?>
            <div class="user__notifications icon_btn_transparent" id="notifyOpen">
                <div class="search notification">
                    <span id="main_notifications_badge"></span>
                </div>
                <svg viewBox="0 0 448 512">
                    <path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                </svg>
            </div>
            <div class="notification-wrapper">
                <div class="notifications__header">
                    <div class="notifications__title"><?= $Translate->get_translate_phrase('_Notifications') ?></div>
                    <div class="noty_clear_all" id="main_notifications_all_del">
                        <?= $Translate->get_translate_phrase('_NotificationsClear') ?>
                        <svg viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </div>

                </div>
                <div class="notifications__main no-scrollbar" id="main_notifications"></div>
            </div>
        <?php endif; ?>
        <!-- Steam auth -->
        <?php if (empty($_SESSION['steamid'])) : ?>
            <div class="auth_user_btn" onclick="location.href='?auth=login'">
                <?= $Translate->get_translate_phrase('_Steam_login') ?>
                <svg viewBox="0 0 496 512">
                    <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                </svg>
            </div>
        <?php endif; ?>
        <!-- User mini-profile -->
        <?php if (!empty($_SESSION['steamid'])) : ?>
            <div id="profMenuOpen">
                <div class="user__avatar">
                    <?= $General->get_js_relevance_avatar($_SESSION['steamid']) ?>
                    <img src="<?= $General->getAvatar($_SESSION['steamid'], 3) ?>" id="avatar" avatarid="<?= $_SESSION['steamid'] ?>">
                </div>
                <div class="user__menu">
                    <div class="user_profile_wrapper">
                        <a href="<?= $General->arr_general['site'] ?>profiles/<?= empty($_SESSION['steamid']) ? 0 : $_SESSION['steamid'] ?>?search=1">
                            <div class="user__profile">
                                <div class="user_avatar_profile" style="position: relative;">
                                    <?= $General->get_js_relevance_avatar($_SESSION['steamid']) ?>
                                    <img style="position: absolute; transform: scale(1.17); border-radius: 0; top: -1px;" src="<?= $General->getFrame($_SESSION['steamid']) ?>" id="frame" frameid="<?= $_SESSION['steamid'] ?>">
                                    <img src="<?= $General->getAvatar($_SESSION['steamid'], 3) ?>" id="avatar" avatarid="<?= $_SESSION['steamid'] ?>">
                                </div>
                                <div class="username_profile">
                                    <div class="prof_nickname"><?= action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13) ?></div>
                                    <?php if (!empty($Db->db_data['lk'])) : ?>
                                        <div class="open_user_prof"><?= $Translate->get_translate_phrase('_Current_balance') ?>: <?= $Modules->get_balance() ?? 0 ?> <?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <div class="user__links">

                            <?php if (!empty($_SESSION['steamid']) && isset($_SESSION['user_admin'])) : ?>
                                <a class="some_link" href="/adminpanel">
                                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                        <g>
                                            <clipPath id="a">
                                                <path d="M0 0h24v24H0z"></path>
                                            </clipPath>
                                            <g clip-path="url(#a)">
                                                <path d="M5 2h3c1.7 0 3 1.3 3 3v3c0 1.7-1.3 3-3 3H5c-1.7 0-3-1.3-3-3V5c0-1.7 1.3-3 3-3zM5 13h3c1.7 0 3 1.3 3 3v3c0 1.7-1.3 3-3 3H5c-1.7 0-3-1.3-3-3v-3c0-1.6 1.3-3 3-3zM16 13h3c1.7 0 3 1.3 3 3v3c0 1.7-1.3 3-3 3h-3c-1.7 0-3-1.3-3-3v-3c0-1.6 1.4-3 3-3zM20.5 7.2h-6c-.4 0-.8-.3-.8-.8s.3-.8.8-.8h6c.4 0 .8.3.8.8s-.4.8-.8.8z"></path>
                                                <path d="M17.5 10.2c-.4 0-.8-.3-.8-.8v-6c0-.4.3-.8.8-.8s.8.3.8.8v6c0 .5-.4.8-.8.8z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Управление сайтом
                                </a>
                            <?php endif; ?>
                            <a class="some_link" data-openmodal="popup_promo_code">
                                <svg viewBox="0 0 448 512"><path d="M0 80L0 229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7L48 32C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                Промокод
                            </a>
                            <?php if (file_exists(MODULES . 'module_page_reports/description.json')) : ?>
                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <a class="some_link" href="/reports">
                                        <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                            <g>
                                                <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z"></path>
                                                <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-4.8 12.1H8c-.4 0-.8-.3-.8-.8 0-.4.3-.7.8-.7h4.4c.4 0 .8.3.8.7-.1.5-.4.8-.8.8zm2.6-4H8c-.4 0-.8-.3-.8-.8s.3-.8.8-.8h7c.4 0 .8.3.8.8s-.4.8-.8.8z"></path>
                                            </g>
                                        </svg>
                                        Репорты
                                    </a>
                                <?php else : ?>
                                    <?php
                                    $array = $Db->queryAll('Reports', 0, 0, "SELECT `steamid` FROM `rs_admins`");
                                    $uniqueSteamIds = array_column($array, 'steamid');
                                    if (in_array($_SESSION['steamid64'], $uniqueSteamIds)) : ?>
                                        <a class="some_link" href="/reports">
                                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                                <g>
                                                    <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z"></path>
                                                    <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-4.8 12.1H8c-.4 0-.8-.3-.8-.8 0-.4.3-.7.8-.7h4.4c.4 0 .8.3.8.7-.1.5-.4.8-.8.8zm2.6-4H8c-.4 0-.8-.3-.8-.8s.3-.8.8-.8h7c.4 0 .8.3.8.8s-.4.8-.8.8z"></path>
                                                </g>
                                            </svg>
                                            Репорты
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (file_exists(MODULES . 'module_page_managersystem/description.json')) : ?>
                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <a class="some_link" href="/managersystem">
                                        <svg x="0" y="0" viewBox="0 0 68 68" xml:space="preserve" class="">
                                            <g>
                                                <path d="M33.992 9.975c-6.11 3.813-12.835 6.303-20.007 7.409v18.228c0 10.54 7.032 16.146 20.015 22.706C49.142 50.6 54.015 45.054 54.015 35.616l-.012-18.232c-7.173-1.105-13.9-3.595-20.011-7.409zm5.583 21.141c.867 0 1.363.988.845 1.683l-9.918 13.317c-.743.996-2.296.112-1.818-1.035l3.552-8.53h-3.853a1.053 1.053 0 0 1-.996-1.395l4.021-11.723c.146-.426.547-.712.997-.712h7.21c.815 0 1.322.884.91 1.587l-4 6.808h3.05z"></path>
                                                <path d="M61.75 14.061c0-2.09-1.614-3.79-3.694-3.983-7.939-.738-15.216-3.334-21.797-7.885a3.983 3.983 0 0 0-4.534 0c-6.58 4.55-13.857 7.146-21.795 7.885-2.081.193-3.695 1.895-3.695 3.986v21.548c0 15.954 11.5 23.336 26.012 30.493a3.976 3.976 0 0 0 3.522-.002c16.233-8.048 25.996-15.542 25.996-30.491l-.014-21.55zM34.34 59.828a.753.753 0 0 1-.675.001c-13.736-6.904-21.18-12.809-21.18-24.217V16.736a.75.75 0 0 1 .645-.742c7.359-1.045 14.242-3.582 20.459-7.538a.751.751 0 0 1 .806 0c6.218 3.958 13.103 6.494 20.463 7.538a.75.75 0 0 1 .645.742l.012 18.88c0 10.08-5.343 16.189-21.175 24.212z"></path>
                                            </g>
                                        </svg>
                                        Управление игроками
                                    </a>
                                <?php else : ?>
                                    <?php if (!empty($Db->queryAll('Core', 0, 0, "SELECT `steamid_access`, `add_admin_access`, `add_vip_access`, `add_access` FROM `lvl_web_managersystem_access`"))) : foreach ($Db->queryAll('Core', 0, 0, "SELECT `steamid_access`, `add_admin_access`, `add_vip_access`, `add_access` FROM `lvl_web_managersystem_access`") as $admin) : if ($admin['steamid_access'] == $_SESSION['steamid64']) : ?>
                                                <a class="some_link" href="/managersystem">
                                                    <svg x="0" y="0" viewBox="0 0 68 68" xml:space="preserve">
                                                        <g>
                                                            <path d="M33.992 9.975c-6.11 3.813-12.835 6.303-20.007 7.409v18.228c0 10.54 7.032 16.146 20.015 22.706C49.142 50.6 54.015 45.054 54.015 35.616l-.012-18.232c-7.173-1.105-13.9-3.595-20.011-7.409zm5.583 21.141c.867 0 1.363.988.845 1.683l-9.918 13.317c-.743.996-2.296.112-1.818-1.035l3.552-8.53h-3.853a1.053 1.053 0 0 1-.996-1.395l4.021-11.723c.146-.426.547-.712.997-.712h7.21c.815 0 1.322.884.91 1.587l-4 6.808h3.05z"></path>
                                                            <path d="M61.75 14.061c0-2.09-1.614-3.79-3.694-3.983-7.939-.738-15.216-3.334-21.797-7.885a3.983 3.983 0 0 0-4.534 0c-6.58 4.55-13.857 7.146-21.795 7.885-2.081.193-3.695 1.895-3.695 3.986v21.548c0 15.954 11.5 23.336 26.012 30.493a3.976 3.976 0 0 0 3.522-.002c16.233-8.048 25.996-15.542 25.996-30.491l-.014-21.55zM34.34 59.828a.753.753 0 0 1-.675.001c-13.736-6.904-21.18-12.809-21.18-24.217V16.736a.75.75 0 0 1 .645-.742c7.359-1.045 14.242-3.582 20.459-7.538a.751.751 0 0 1 .806 0c6.218 3.958 13.103 6.494 20.463 7.538a.75.75 0 0 1 .645.742l.012 18.88c0 10.08-5.343 16.189-21.175 24.212z"></path>
                                                        </g>
                                                    </svg>
                                                    Управление игроками
                                                </a>
                                <?php endif;
                                        endforeach;
                                    endif;
                                endif; ?>
                            <?php endif; ?>
                            
                            <?php if (file_exists(MODULES . 'module_page_admins_online/description.json')) : ?>
                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <a class="some_link" href="/admins_online">
                                        <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                            <g>
                                                <circle cx="386" cy="210" r="20"></circle>
                                                <path d="M432 40h-26V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-91V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-90V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20H80C35.888 40 0 75.888 0 120v312c0 44.112 35.888 80 80 80h153c11.046 0 20-8.954 20-20s-8.954-20-20-20H80c-22.056 0-40-17.944-40-40V120c0-22.056 17.944-40 40-40h25v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h90v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h91v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h26c22.056 0 40 17.944 40 40v114c0 11.046 8.954 20 20 20s20-8.954 20-20V120c0-44.112-35.888-80-80-80z"></path>
                                                <path d="M391 270c-66.72 0-121 54.28-121 121s54.28 121 121 121 121-54.28 121-121-54.28-121-121-121zm0 202c-44.663 0-81-36.336-81-81s36.337-81 81-81 81 36.336 81 81-36.337 81-81 81z"></path>
                                                <path d="M420 371h-9v-21c0-11.046-8.954-20-20-20s-20 8.954-20 20v41c0 11.046 8.954 20 20 20h29c11.046 0 20-8.954 20-20s-8.954-20-20-20z"></path>
                                                <circle cx="299" cy="210" r="20"></circle>
                                                <circle cx="212" cy="297" r="20"></circle>
                                                <circle cx="125" cy="210" r="20"></circle>
                                                <circle cx="125" cy="297" r="20"></circle>
                                                <circle cx="125" cy="384" r="20"></circle>
                                                <circle cx="212" cy="384" r="20"></circle>
                                                <circle cx="212" cy="210" r="20"></circle>
                                            </g>
                                        </svg>
                                        Онлайн админов
                                    </a>
                                <?php else : ?>
                                    <?php $admin = $Db->query('Core', 0, 0, "SELECT `sid`, `end` FROM `iks_admins` WHERE `sid` = '" . $_SESSION['steamid64'] . "' AND (`end` = 0 OR `end` > '" . time() . "')") ?>
                                    <?php if (!empty($admin['sid'])) : ?>
                                        <a class="some_link" href="/admins_online">
                                            <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                                <g>
                                                    <circle cx="386" cy="210" r="20"></circle>
                                                    <path d="M432 40h-26V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-91V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-90V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20H80C35.888 40 0 75.888 0 120v312c0 44.112 35.888 80 80 80h153c11.046 0 20-8.954 20-20s-8.954-20-20-20H80c-22.056 0-40-17.944-40-40V120c0-22.056 17.944-40 40-40h25v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h90v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h91v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h26c22.056 0 40 17.944 40 40v114c0 11.046 8.954 20 20 20s20-8.954 20-20V120c0-44.112-35.888-80-80-80z"></path>
                                                    <path d="M391 270c-66.72 0-121 54.28-121 121s54.28 121 121 121 121-54.28 121-121-54.28-121-121-121zm0 202c-44.663 0-81-36.336-81-81s36.337-81 81-81 81 36.336 81 81-36.337 81-81 81z"></path>
                                                    <path d="M420 371h-9v-21c0-11.046-8.954-20-20-20s-20 8.954-20 20v41c0 11.046 8.954 20 20 20h29c11.046 0 20-8.954 20-20s-8.954-20-20-20z"></path>
                                                    <circle cx="299" cy="210" r="20"></circle>
                                                    <circle cx="212" cy="297" r="20"></circle>
                                                    <circle cx="125" cy="210" r="20"></circle>
                                                    <circle cx="125" cy="297" r="20"></circle>
                                                    <circle cx="125" cy="384" r="20"></circle>
                                                    <circle cx="212" cy="384" r="20"></circle>
                                                    <circle cx="212" cy="210" r="20"></circle>
                                                </g>
                                            </svg>
                                            Онлайн админов
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="user_profile_footer">
                        <div class="user_settings_miniprof" onclick="location.href='<?= $General->arr_general['site'] ?>profiles/<?= $_SESSION['steamid64'] ?>/settings/'" data-tippy-content="Настройки" data-tippy-placement="right">
                            <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                <g>
                                    <path d="M29.21 11.84a3.92 3.92 0 0 1-3.09-5.3 1.84 1.84 0 0 0-.55-2.07 14.75 14.75 0 0 0-4.4-2.55 1.85 1.85 0 0 0-2.09.58 3.91 3.91 0 0 1-6.16 0 1.85 1.85 0 0 0-2.09-.58 14.82 14.82 0 0 0-4.1 2.3 1.86 1.86 0 0 0-.58 2.13 3.9 3.9 0 0 1-3.25 5.36 1.85 1.85 0 0 0-1.62 1.49A14.14 14.14 0 0 0 1 16a14.32 14.32 0 0 0 .19 2.35 1.85 1.85 0 0 0 1.63 1.55A3.9 3.9 0 0 1 6 25.41a1.82 1.82 0 0 0 .51 2.18 14.86 14.86 0 0 0 4.36 2.51 2 2 0 0 0 .63.11 1.84 1.84 0 0 0 1.5-.78 3.87 3.87 0 0 1 3.2-1.68 3.92 3.92 0 0 1 3.14 1.58 1.84 1.84 0 0 0 2.16.61 15 15 0 0 0 4-2.39 1.85 1.85 0 0 0 .54-2.11 3.9 3.9 0 0 1 3.13-5.39 1.85 1.85 0 0 0 1.57-1.52A14.5 14.5 0 0 0 31 16a14.35 14.35 0 0 0-.25-2.67 1.83 1.83 0 0 0-1.54-1.49zM21 16a5 5 0 1 1-5-5 5 5 0 0 1 5 5z"></path>
                                </g>
                            </svg>
                        </div>
                        <a class="user_logout" href="<?= $General->arr_general['site'] ?>?auth=logout">
                            <?= $Translate->get_translate_phrase('_Logout') ?>
                            <svg viewBox="0 0 512 512">
                                <path d="M160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96C43 32 0 75 0 128V384c0 53 43 96 96 96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H96c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32h64zM504.5 273.4c4.8-4.5 7.5-10.8 7.5-17.4s-2.7-12.9-7.5-17.4l-144-136c-7-6.6-17.2-8.4-26-4.6s-14.5 12.5-14.5 22v72H192c-17.7 0-32 14.3-32 32l0 64c0 17.7 14.3 32 32 32H320v72c0 9.6 5.7 18.2 14.5 22s19 2 26-4.6l144-136z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row second_nav" style="margin:10px -10px 0">
    <div class="nav_second_left">
        <a class="nav_logo_text_center" href="/">
            <?php if (!$settings_neo['SVGLogo']) : ?>
                <div class="nav_sitename">
                    <?= $settings_neo['SiteName'] ?>
                </div>
            <?php else : ?>
                <div class="site_logo_neo" data-tippy-content="<?= $settings_neo['SiteName'] ?>" data-tippy-placement="bottom">
                    <?= $settings_neo['SVGLogo'] ?>
                </div>
            <?php endif; ?>
        </a>
        <div class="nav_devider"></div>
        <span class="nav_soc_text">Наши соц сети</span>
        <div class="social_buttons social_nav">
            <?php if (!empty($settings_neo['VK'])) : ?>
                <a href="<?= $settings_neo['VK'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_VK') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg viewBox="0 0 448 512">
                            <path d="M31.4907 63.4907C0 94.9813 0 145.671 0 247.04V264.96C0 366.329 0 417.019 31.4907 448.509C62.9813 480 113.671 480 215.04 480H232.96C334.329 480 385.019 480 416.509 448.509C448 417.019 448 366.329 448 264.96V247.04C448 145.671 448 94.9813 416.509 63.4907C385.019 32 334.329 32 232.96 32H215.04C113.671 32 62.9813 32 31.4907 63.4907ZM75.6 168.267H126.747C128.427 253.76 166.133 289.973 196 297.44V168.267H244.16V242C273.653 238.827 304.64 205.227 315.093 168.267H363.253C359.313 187.435 351.46 205.583 340.186 221.579C328.913 237.574 314.461 251.071 297.733 261.227C316.41 270.499 332.907 283.63 346.132 299.751C359.357 315.873 369.01 334.618 374.453 354.747H321.44C316.555 337.262 306.614 321.61 292.865 309.754C279.117 297.899 262.173 290.368 244.16 288.107V354.747H238.373C136.267 354.747 78.0267 284.747 75.6 168.267Z" />
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (!empty($settings_neo['TG'])) : ?>
                <a href="<?= $settings_neo['TG'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_TG') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve">
                            <g>
                                <path d="M89.442 11.418c-12.533 5.19-66.27 27.449-81.118 33.516-9.958 3.886-4.129 7.529-4.129 7.529s8.5 2.914 15.786 5.1 11.172-.243 11.172-.243l34.244-23.073c12.143-8.257 9.229-1.457 6.315 1.457-6.315 6.315-16.758 16.272-25.501 24.287-3.886 3.4-1.943 6.315-.243 7.772 6.315 5.343 23.558 16.272 24.53 17.001 5.131 3.632 15.223 8.861 16.758-2.186l6.072-38.13c1.943-12.872 3.886-24.773 4.129-28.173.728-8.257-8.015-4.857-8.015-4.857z"></path>
                            </g>
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (!empty($settings_neo['Steam'])) : ?>
                <a href="<?= $settings_neo['Steam'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_STM') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg viewBox="0 0 496 512">
                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (!empty($settings_neo['DS'])) : ?>
                <a href="<?= $settings_neo['DS'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_DS') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg viewBox="0 0 640 512">
                            <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z" />
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (!empty($settings_neo['YT'])) : ?>
                <a href="<?= $settings_neo['YT'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_YT') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg viewBox="0 0 576 512">
                            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" />
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (!empty($settings_neo['TT'])) : ?>
                <a href="<?= $settings_neo['TT'] ?>" target="_blank" data-tippy-content="<?= $Translate->get_translate_phrase('_TT') ?>" data-tippy-placement="top">
                    <div class="social_but">
                        <svg viewBox="0 0 448 512">
                            <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z" />
                        </svg>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="nav_second_right">
        <div class="search_players" id="open_search">
            <div class="modal-searchcontent">
                <form enctype="multipart/form-data" method="post" class="input-form input-search">
                    <input type="text" placeholder="<?= $Translate->get_translate_phrase('_PlaceholderSearch') ?>" name="_steam_id" style="height:49px">
                    <input type="hidden" name="btn_search">
                    <svg class='input__icon'>
                        <use xlink:href='#input-search-icon'></use>
                    </svg>
                    <svg style='display: none;'>
                        <symbol id='input-search-icon' viewBox="0 0 512 512">
                            <g>
                                <path id='input-search-icon' d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z" />
                            </g>
                        </symbol>
                    </svg>
                </form>
            </div>
            <div class="modal_users_container">
                <div class="modal_blocks_content no-scrollbar">
                    <div class="modal_users_header" id="search_header">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>