<div class="col-md-4 addon_gap">
    <div class="stats_general_block">
        <div class="stats_total_players"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_total_players') ?>
            <span><?php if (!empty($Db->db_data['LevelsRanks'])) { echo $Admin->InfoStatsCached()['CountPlayers']; } else { echo '—'; } ?></span>
            <svg x="0" y="0" viewBox="0 0 548.505 548.505" xml:space="preserve">
                <g>
                    <g fill-rule="evenodd" clip-rule="evenodd">
                        <circle cx="140.327" cy="290.573" r="86.445"></circle>
                        <circle cx="408.179" cy="86.572" r="86.445"></circle>
                        <path d="M510.255 401.727c0-10.557 8.593-19.1 19.125-19.1 10.557 0 19.125 8.593 19.125 19.15l-.077 76.551c-.051 38.684-31.416 70.048-70.125 70.048H338.002c-10.557 0-19.125-8.568-19.125-19.125s8.568-19.125 19.125-19.125h140.301c17.595 0 31.85-14.255 31.875-31.85zM38.378 146.778c0 10.557-8.593 19.1-19.15 19.1s-19.1-8.593-19.1-19.15l.077-76.551C.23 31.492 31.62.127 70.329.127h191.173c10.557 0 19.125 8.568 19.125 19.125s-8.568 19.125-19.125 19.125H70.329c-17.595 0-31.849 14.254-31.875 31.85zM223.151 365.848c34.833 25.551 57.477 66.785 57.477 113.246 0 19.864-12.521 37.179-35.547 49.087-25.423 13.158-65.05 20.196-104.754 20.196-39.729 0-79.356-7.038-104.78-20.196C12.521 516.273 0 498.958 0 479.094c0-46.461 22.644-87.694 57.477-113.246 20.502 22.542 50.031 36.669 82.85 36.669 32.793.001 62.347-14.126 82.824-36.669zM491.028 161.848c34.833 25.551 57.477 66.785 57.477 113.245 0 19.865-12.521 37.179-35.547 49.087-25.423 13.158-65.051 20.196-104.78 20.196-39.703 0-79.331-7.038-104.754-20.196-23.026-11.908-35.547-29.223-35.547-49.087 0-46.461 22.644-87.695 57.477-113.245 20.477 22.542 50.031 36.669 82.824 36.669 32.819 0 62.348-14.127 82.85-36.669z"></path>
                    </g>
                </g>
            </svg>
        </div>
        <div class="stats_all_cash">
            <div style="color: var(--money);"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_total_earned_month') . ' ' . $Admin->getMonthName(date('n')) ?></div>
            <span style="color: var(--money);"><?php if (!empty($Db->db_data['lk'])) { if ($Admin->InfoStatsCached()['CountMoneyMonth']['total_earned']) { echo $Admin->InfoStatsCached()['CountMoneyMonth']['total_earned']; } else { echo '0'; } } else { echo '—'; } ?></span>
            <div class="current_amount"><?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?></div>
        </div>
    </div>
    <div class="stats_general_block">
        <div class="stats_players_day"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_24h_players') ?>
            <span><?php if (!empty($Db->db_data['LevelsRanks'])) { echo $Admin->InfoStats()['CountPlayers24']; } else { echo '—'; } ?></span>
            <svg x="0" y="0" viewBox="0 0 1707 1707" xml:space="preserve" fill-rule="evenodd">
                <g>
                    <path d="M1021 1650c-320 0-590-220-665-518H20c-11 0-20-9-20-20s9-20 20-20h328c-7-35-11-71-12-107H73c-26 0-26-40 0-40h263c1-37 5-72 11-107H20c-11 0-20-9-20-20s9-20 20-20h336c36-141 115-265 223-357l-44-72c-31-51 6-120 68-120 29 0 55 16 69 40l39 65c65-33 135-56 209-67V183c-59 0-49 7-49-107 0-11 8-20 20-20h261c11 0 20 9 20 20 0 114 10 107-50 107v104c75 11 146 34 211 67l37-65c35-60 127-49 145 19 6 21 3 42-7 61l-43 74c148 125 242 313 242 522 0 378-308 685-686 685zm23-764 96-167c13-23 48-3 35 20l-97 167c53 51 17 141-57 141-45 0-82-37-82-82 0-55 52-94 105-79zM805 611c-6 0-13-3-17-10l-30-52c-62 39-114 91-153 152l53 31c22 13 2 48-20 35l-53-31c-33 63-53 134-56 209h61c26 0 26 40 0 40h-61c3 75 23 146 56 209l53-31c22-13 42 22 20 35l-53 30c39 62 91 114 153 153l30-53c13-22 48-2 35 20l-31 53c63 33 134 53 209 56v-61c0-26 40-26 40 0v61c75-3 146-23 209-56l-31-53c-13-22 22-42 35-20l31 53c61-39 113-91 152-153l-52-30c-23-13-3-48 20-35l52 31c34-63 53-134 57-209h-62c-26 0-26-40 0-40h62c-3-75-23-146-57-209-13 8-52 33-62 33-21 0-28-27-10-37l52-31c-39-61-91-113-152-152l-31 52c-13 23-48 3-35-20l31-52c-63-34-134-54-209-57v62c0 26-40 26-40 0v-62c-75 3-146 23-209 57l31 52c7 14-2 30-18 30z"></path>
                </g>
            </svg>
        </div>
        <div class="stats_all_cash">
            <div style="color: var(--money);"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_total_earned') ?></div>
            <span style="color: var(--money);"><?php if (!empty($Db->db_data['lk'])) { if ($Admin->InfoStatsCached()['CountMoney']['cash_summ']) { echo $Admin->InfoStatsCached()['CountMoney']['cash_summ']; } else { echo '0'; } } else { echo '—'; } ?></span>
            <div class="current_amount"><?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?></div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="stats_privilegies">
        <div class="stats_admins">
            <div style="color: var(--span);"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_admins') ?></div>
            <span style="color: var(--span);"><?php if (!empty($Db->db_data['AdminSystem'] || $Db->db_data['IksAdmin'])) { echo $Admin->InfoStatsCached()['CountAdmins']; } else { echo '—'; } ?></span>
            <svg style="fill: var(--span); opacity: .1;" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                <g>
                    <path d="M255.303 255.424c43.625 0 75.282-21.503 91.55-62.184 12.484-31.222 14.168-68.052 14.168-99.962C361.021 34.953 321.5.132 255.303.132s-105.718 34.82-105.718 93.146c0 31.91 1.684 68.74 14.168 99.962 16.268 40.681 47.925 62.184 91.55 62.184zM294.538 282.981h-79.076c-75.721 0-137.323 61.603-137.323 137.323v9.385c0 45.313 36.864 82.178 82.178 82.178h189.367c45.313 0 82.178-36.865 82.178-82.178v-9.385c-.001-75.721-61.603-137.323-137.324-137.323zM393.021 93.279c0 53.208-5.302 111.544-40.633 152.23 8.811 3.457 18.686 5.228 29.548 5.228 33.045 0 57.022-16.283 69.341-47.091 9.161-22.91 10.396-49.624 10.396-72.735 0-40.542-25.736-68.041-72.354-70.597 2.449 10.359 3.702 21.377 3.702 32.965zM130.495 250.737c10.302 0 19.721-1.583 28.182-4.695-35.788-40.739-41.092-99.612-41.092-152.763 0-11.544 1.244-22.523 3.676-32.849-42.984 2.996-70.504 28.181-70.504 70.48 0 23.11 1.235 49.825 10.396 72.736 12.32 30.808 36.297 47.091 69.342 47.091z"></path>
                    <path d="M46.139 420.304c0-61.679 33.153-115.754 82.572-145.356H102.19C45.843 274.948 0 320.791 0 377.139v6.667c0 29.264 20.053 53.93 47.139 60.985-1.188-8.948-1-14.413-1-24.487zM409.81 274.948h-28.506c49.412 29.605 82.557 83.683 82.557 145.356 0 9.979.202 15.706-1.069 24.974C490.917 438.964 512 413.809 512 383.806v-6.667c0-56.348-45.843-102.191-102.19-102.191z"></path>
                </g>
            </svg>
        </div>
        <div class="stats_vips">
            <div style="color: var(--top-one);"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_vips') ?></div>
            <span style="color: var(--top-one);"><?php if (!empty($Db->db_data['Vips'])) { echo $Admin->InfoStatsCached()['CountVip']; } else { echo '—'; } ?></span>
            <svg style="fill: var(--top-one); opacity: .1;" x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                <g>
                    <g>
                        <path d="M2.837 20.977 1.012 9.115c-.135-.876.863-1.474 1.572-.942l5.686 4.264a1.359 1.359 0 0 0 1.945-.333l4.734-7.1c.5-.75 1.602-.75 2.102 0l4.734 7.1a1.359 1.359 0 0 0 1.945.333l5.686-4.264c.71-.532 1.707.066 1.572.942l-1.825 11.862zM27.79 27.559H4.21a1.373 1.373 0 0 1-1.373-1.373v-3.015h26.326v3.015c0 .758-.615 1.373-1.373 1.373z"></path>
                    </g>
                </g>
            </svg>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="stats_action_blocks">
        <div class="stats_bans">
            <div><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_bans') ?></div>
            <span><?php if (!empty($Db->db_data['AdminSystem'] || $Db->db_data['IksAdmin'])) { echo $Admin->InfoStatsCached()['CountBans']; } else { echo '—'; } ?></span>
            <svg x="0" y="0" viewBox="0 0 48 48" xml:space="preserve">
                <g>
                    <path d="M46 24a21.99 21.99 0 1 0-22 22 22.027 22.027 0 0 0 22-22zm-35.227 8.985a15.988 15.988 0 0 1 22.212-22.212zm4.242 4.242 22.212-22.212a15.988 15.988 0 0 1-22.212 22.212z"></path>
                </g>
            </svg>
        </div>
        <div class="stats_comms">
            <div><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_comms') ?></div>
            <span><?php if (!empty($Db->db_data['AdminSystem'] || $Db->db_data['IksAdmin'])) { echo $Admin->InfoStatsCached()['CountMutes']; } else { echo '—'; } ?></span>
            <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                <g>
                    <path d="m9.036 21.877.002.002-1.413 1.412-.002-.002-1.916 1.916a.997.997 0 0 1-1.414 0 .999.999 0 0 1 0-1.414l1.923-1.924c-1.262-1.551-2.001-3.416-2.001-5.422a1 1 0 1 1 2 0c0 1.465.527 2.83 1.424 4l2.203-2.204c-.47-.745-.742-1.584-.742-2.474V5.509c0-3.045 3.096-5.521 6.9-5.521 3.676 0 6.681 2.313 6.881 5.215l2.566-2.565a.999.999 0 1 1 1.414 1.414zm18.749-5.432a1 1 0 1 0-2 0c0 4.271-4.389 7.745-9.784 7.745-1.926 0-3.718-.449-5.234-1.212l-1.471 1.471c1.647.946 3.598 1.556 5.705 1.704L15 29.987h-2.64a1 1 0 1 0 0 2h7.279a1 1 0 1 0 0-2H17l.001-3.839c6.031-.421 10.784-4.609 10.784-9.703zm-4.885-.678v-4.982l-9.935 9.935c.917.361 1.945.57 3.034.57 3.806-.001 6.901-2.478 6.901-5.523z"></path>
                </g>
            </svg>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="stats_general_block" style="height: 100%;">
        <div class="stats_visits" style="justify-content: flex-start;">
            <div class="visit_top">
                <div class="visit_title"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_visit_30d') ?></div>
                <div class="visit_count"><?= $Admin->InfoStats()['CountVisit']['visits'] ?> <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_visit_humans') ?></div>
            </div>
            <div class="visit_online">
                <div class="visit_online_title"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_visit_online') ?> <?= $Admin->InfoStats()['VisitsUsersCount'] ?></div>
                <div class="visit_user_list no-scrollbar">
                    <?php foreach ($Admin->InfoStats()['VisitsUsers'] as $key) : ?>
                        <div class="visit_user_block">
                            <?php $General->get_js_relevance_avatar($key['user']) ?>
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= con_steam64($key['user']) ?>/?search=1"><img src="<?= $General->getAvatar(con_steam64($key['user']), 3) ?>" id="avatar" avatarid="<?= con_steam64($key['user']) ?>"></a>
                            <div class="visit_info">
                                <div class="visit_user_info">
                                    <div class="visit_user_name"><?php if ($key['user'] == 'guest') { echo 'Гость'; } else { echo action_text_trim($General->checkName($key['user']), 16); } ?> <span>(IP: <?= action_text_trim($key['ip'], 20) ?>)</span>
                                        <svg class="copyuserip" data-clipboard-text="<?= $key['ip'] ?>" viewBox="0 0 512 512">
                                            <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                        </svg>
                                    </div>
                                    <div class="visit_last_activity"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_visit_last_activity') ?> <?= date('H:i, d.m.Y ', strtotime($key['time'])) ?></div>
                                </div>
                                <?php if ($key['user'] != 'guest') : ?>
                                <a class="visit_steam_link" href="//steamcommunity.com/profiles/<?= $key['user'] ?>/" target="_blank">
                                    <svg viewBox="0 0 496 512">
                                        <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (file_exists(MODULES . 'module_page_store/description.json')) : ?>
<div class="<?php if (empty($Db->db_data['lk'])) : ?>col-md-12<?php else : ?>col-md-6<?php endif; ?>">
    <div class="stats_general_block">
        <div class="stats_shop_purchase">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_purchases') ?></div>
            <div class="stats_buy_list no-scrollbar">
                <?php foreach ($Admin->InfoStats()['LastShopPay'] as $key) : ?>
                    <div class="stats_buy_block">
                        <div class="last_donate_info">
                            <?php $General->get_js_relevance_avatar(con_steam64($key['steam'])) ?>
                            <div class="stats_buyer_avatar">
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= con_steam64($key['steam']) ?>/?search=1"><img src="<?= $General->getAvatar(con_steam64($key['steam']), 3) ?>" id="avatar" avatarid="<?= con_steam64($key['steam']) ?>"></a>
                            </div>
                            <div class="stats_buyer_info">
                                <span class="stats_buyer_nick"><?= action_text_trim($General->checkName(con_steam64($key['steam'])), 16) ?></span>
                                <span class="stats_buyer_time"><?= date('d.m.Y H:i:s ', strtotime($key['date'])) ?></span>
                            </div>
                        </div>
                        <div class="stats_buy_amount">
                            <?php if(file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) { echo $key['title'] . ' | ' .  $key['price'] . ' ' . $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'); } else { echo $key['title']; } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (!empty($Db->db_data['lk'])) : ?>
<div class="<?php if (!file_exists(MODULES . 'module_page_store/description.json')) : ?>col-md-12<?php else : ?>col-md-6<?php endif; ?>">
    <div class="stats_general_block">
        <div class="stats_pays">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Stats_transactions') ?></div>
            <div class="stats_pay_list no-scrollbar">
                <?php foreach ($Admin->InfoStats()['LastPay'] as $key) : ?>
                    <div class="stats_pay_block">
                        <div class="last_donate_info">
                            <?php $General->get_js_relevance_avatar(con_steam64($key['pay_auth'])) ?>
                            <div class="stats_donater_avatar">
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= con_steam64($key['pay_auth']) ?>/?search=1"><img src="<?= $General->getAvatar(con_steam64($key['pay_auth']), 3) ?>" id="avatar" avatarid="<?= con_steam64($key['pay_auth']) ?>"></a>
                            </div>
                            <div class="stats_donater_info">
                                <span class="stats_donater_nick"><?= action_text_trim($General->checkName(con_steam64($key['pay_auth'])), 16) ?></span>
                                <span class="stats_donater_time"><?= $key['pay_data'] ?></span>
                            </div>
                        </div>
                        <div class="stats_donate_amount">
                            <?= $key['pay_summ'] . ' ' . $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>