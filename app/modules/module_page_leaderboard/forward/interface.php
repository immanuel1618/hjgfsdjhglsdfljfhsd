<?php
function getColorClass($value) {
    if ($value > 30000) { return 'gold-rank'; }
    elseif ($value > 25000) { return 'red-rank'; }
    elseif ($value > 20000) { return 'pink-rank'; }
    elseif ($value > 15000) { return 'purple-rank'; }
    elseif ($value > 9999) { return 'blue-rank'; }
    elseif ($value > 5000) { return 'wblue-rank'; }
    else { return 'gray-rank'; }
}

function getColorClassTop3($value) {
    if ($value > 30000) { return 'gold-rank-top'; }
    elseif ($value > 25000) { return 'red-rank-top'; }
    elseif ($value > 20000) { return 'pink-rank-top'; }
    elseif ($value > 15000) { return 'purple-rank-top'; }
    elseif ($value > 9999) { return 'blue-rank-top'; }
    elseif ($value > 5000) { return 'wblue-rank-top'; }
    else { return 'gray-rank-top'; }
}
?>
<div class="row">
    <div class="col-md-3">
        <select style="display: none;" class="custom-select" onchange="window.location.href=this.value" placeholder="<?php for ($b = 0; $b < $Db->table_statistics_count; $b++) { if (($Db->statistics_table[$b]['name']) == ($Db->statistics_table[$server_group]['name'])) { echo $Db->statistics_table[$b]['name']; } } ?>">
			<?php for ($b = 0; $b < $Db->table_statistics_count; $b++) : ?>
				<option value="<?= set_url_section(get_url(2), 'server_group', $b) ?>"><?= $Db->statistics_table[$b]['name'] ?></option>
			<?php endfor; ?>
		</select>
        <div class="top_three_block">
            <div class="card top_block_header">
                <?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_Top3'); ?>
                <span><?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_Best_player'); ?></span>
            </div>
            <?php foreach ($top3 as $id => $row): $General->get_js_relevance_avatar(con_steam64($row['steam'])); $colorClassTop3 = getColorClassTop3($row['value']); ?> 
                <div onclick="window.open('<?= $General->arr_general['site'] . 'profiles/' . con_steam64($row['steam']) . '/' . $server_group; ?>');" class="top_block_content back_top<?= $id + 1 ?>">
                    <div class="header_top-block-content">
                        <div class="users_data">
                            <img class="avatar_frame" src="<?= $General->getFrame(con_steam64($row['steam'])) ?>" id="frame" frameid="<?= con_steam64($row['steam']) ?>" alt="">
                            <img src="<?= $General->getAvatar(con_steam64($row['steam']), 3 )?>" id="avatar" avatarid="<?= con_steam64($row['steam']) ?>" alt="profile">
                            <div class="users_place_nickname">
                                <span class="users_top_place users_top_place<?= $id + 1 ?>">
                                    <?= $id + 1 ?> <?= $Translate->get_translate_phrase('_Rating') ?>
                                </span>
                                <div class="users_nickname">
                                    <?= htmlspecialchars($row['name'])?>
                                </div>
                            </div>
                        </div>
                        <img class="place_image" src="/../../app/modules/module_page_leaderboard/assets/img/<?= $id + 1 ?>.svg" alt="">
                    </div>
                    <hr>
                    <div class="bottom-block-content">
                    <div class="<?= $colorClassTop3 ?>"><?= number_format($row['value'], 0, '.', ' ') ?></div>
                        <div class="rating_value">
                            <span class="rang_title">Рейтинг</span>
                            <span class="rang_value"><?= number_format($row['value'], 0, '.', ' ') ?> <?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_Experience'); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card" style="background: transparent !important">
            <div class="top_players_head">
                <span class="col_1">
                    <svg viewBox="0 0 384 512">
                        <path d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192c0-44.2-35.8-80-80-80s-80 35.8-80 80s35.8 80 80 80s80-35.8 80-80zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z" />
                    </svg>
                </span>
                    <span class="col_2">
                        <svg viewBox="0 0 512 512">
                            <path d="M105.4 67.08C118.2 44.81 141.1 31.08 167.7 31.08H344.3C370 31.08 393.8 44.81 406.6 67.08L494.9 219.1C507.8 242.3 507.8 269.7 494.9 291.1L406.6 444.9C393.8 467.2 370 480.9 344.3 480.9H167.7C141.1 480.9 118.2 467.2 105.4 444.9L17.07 291.1C4.206 269.7 4.206 242.3 17.07 219.1L105.4 67.08zM158.3 279.8L107.1 335.9L153.9 416.9C156.7 421.9 161.1 424.9 167.7 424.9H344.3C350 424.9 355.3 421.9 358.1 416.9L413.4 321.2L340.7 233.8C336.2 228.3 329.4 225.1 322.3 225.1C315.2 225.1 308.4 228.3 303.8 233.8L232.2 320L193.3 279.4C188.7 274.6 182.4 271.9 175.7 272C169.1 272.1 162.8 274.9 158.3 279.8V279.8zM192 199.1C214.1 199.1 232 182.1 232 159.1C232 137.9 214.1 119.1 192 119.1C169.9 119.1 152 137.9 152 159.1C152 182.1 169.9 199.1 192 199.1z" />
                        </svg>
                    </span>
                <span class="col_3"><?= $Translate->get_translate_phrase('_Player') ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'value') ?>';" class="col_4 pointer hvr <?php $_SESSION['filter'] == 'value' && print 'selected'; ?>"><?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_Experience'); ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'kills') ?>';" class="col_6 pointer hvr <?php $_SESSION['filter'] == 'kills' && print 'selected'; ?>"><?= $Translate->get_translate_phrase('_Kills') ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'deaths') ?>';" class="col_7 pointer hvr <?php $_SESSION['filter'] == 'deaths' && print 'selected'; ?>"><?= $Translate->get_translate_phrase('_Deaths') ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'kd') ?>';" class="col_8 pointer hvr <?php $_SESSION['filter'] == 'kd' && print 'selected'; ?>"><?= $Translate->get_translate_phrase('_Ratio_KD_short') ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'headshots') ?>';" class="col_9 pointer hvr <?php $_SESSION['filter'] == 'headshots' && print 'selected'; ?>"><?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_KilHead'); ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'playtime') ?>';" class="col_10 pointer hvr <?php $_SESSION['filter'] == 'playtime' && print 'selected'; ?>"><?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_Played'); ?></span>
                <span onclick="location.href = '<?= set_url_section(get_url(2), 'filter', 'lastconnect') ?>';" class="col_11 pointer hvr <?php $_SESSION['filter'] == 'lastconnect' && print 'selected'; ?>"><?= $Translate->get_translate_phrase('_Plays_since') ?></span>
            </div>
            <ul class="top_players_list_body">
                <?php if(!empty($_SESSION['steamid64'])) : foreach ($user as $id => $us): $General->get_js_relevance_avatar(con_steam64($us['steam'])); $colorClass = getColorClass($us['value']); ?>
                    <li class="pointer player_top_login" onclick="location.href = '<?= $General->arr_general['site'] . 'profiles/' . con_steam64($us['steam']) . '/' . $server_group; ?>';">
                        <span class="col_1"><?= $Db->query( 'LevelsRanks', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT COUNT(1) AS `top` FROM (SELECT `value` FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE `value` >= " . $us['value'] . " AND `lastconnect` > 0) t;")['top'] ?></span>
                        <span class="col_2">
                            <img class="avatar_frame_small" src="<?= $General->getFrame(con_steam64($us['steam']))  ?>" id="frame" frameid="<?= con_steam64($us['steam'])?>">
                            <img class="top_players_avatar" src="<?= $General->getAvatar(con_steam64($us['steam']), 3 )?>" id="avatar" avatarid="<?= con_steam64($us['steam'])?>">
                            <div class="user_online_status" style="<?php if ($General->user_online(con_steam64($us['steam'])) == 1) { echo 'display: block;'; } ?>"></div>
                        </span>
                        <span class="col_3"><a data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_leaderboard', '_YourStats'); ?>"><?= htmlspecialchars(action_text_trim(($us['name'] ?: $General->checkName($us['steam'])), 16) ?: 'Unknown'); ?></a></span>
                        <span class="col_4"><div class="<?= $colorClass ?>"><?= number_format($us['value'], 0, '.', ' ') ?></div></span>
                        <span class="col_6"><?= number_format($us['kills'], 0, '.', ' ')?></span>
                        <span class="col_7"><?= number_format($us['deaths'], 0, '.', ' ')?></span>
                        <span class="col_8"><?= $us['kd'] ?? 0 ?></span>
                        <span class="col_9"><?= number_format($us['headshots'], 0, '.', ' ')?></span>
                        <span class="col_10"><?= $Modules->action_time_exchange_exact($us['playtime']) ?></span>
                        <span class="col_11"><?= date('d.m.Y в H:i', $us['lastconnect']) ?></span>
                    </li>
                <?php endforeach; endif; ?>
            </ul>
            <ul class="top_players_list_body top_list_scroll no-scrollbar">
                <?php foreach ($res as $id => $row): $General->get_js_relevance_avatar(con_steam64($row['steam'])); $colorClass = getColorClass($row['value']); ?>
                    <li class="pointer top_player_top" onclick="location.href = '<?= $General->arr_general['site'] . 'profiles/' . con_steam64($row['steam']) . '/' . $server_group; ?>';">
                        <span class="col_1"><?= ++$page_num_min + 3 ?></span>
                        <span class="col_2">
                            <img class="avatar_frame_small" src="<?= $General->getFrame(con_steam64($row['steam'])) ?>" id="frame" frameid="<?= con_steam64($row['steam'])?>">
                            <img class="top_players_avatar" src="<?= $General->getAvatar(con_steam64($row['steam']), 3 )?>" id="avatar" avatarid="<?= con_steam64($row['steam'])?>">
                            <div class="user_online_status" style="<?php if ($General->user_online(con_steam64($row['steam'])) == 1) { echo 'display: block;'; } ?>"></div>
                        </span>
                        <span class="col_3"><a><?= htmlspecialchars(action_text_trim(($row['name'] ?: $General->checkName($row['steam'])), 14) ?: 'Unknown'); ?></a></span>
                        <span class="col_4"><div class="<?= $colorClass ?>"><?= number_format($row['value'], 0, '.', ' ') ?></div></span>
                        <span class="col_6"><?= number_format($row['kills'], 0, '.', ' ')?></span>
                        <span class="col_7"><?= number_format($row['deaths'], 0, '.', ' ')?></span>
                        <span class="col_8"><?= $row['kd'] ?? 0 ?></span>
                        <span class="col_9"><?= number_format($row['headshots'], 0, '.', ' ')?></span>
                        <span class="col_10"><?= $Modules->action_time_exchange_exact($row['playtime']) ?></span>
                        <span class="col_11"><?= date('d.m.Y в H:i', $row['lastconnect']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="pagination">
            <?php if ($page_num != 1) : ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512">
                        <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                    </svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512">
                        <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                    </svg></a>
            <?php endif; ?>
            <?php if ($page_max < 5) : for ($i = 1; $i <= $page_max; $i++) : ?>
                    <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
                <?php endfor;
            else : for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++) : ?>
                    <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
            <?php endfor;
            endif; ?>
            <?php if ($page_num != $page_max) : ?>
                <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512">
                        <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                    </svg></a>
                <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512">
                        <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                    </svg></a>
            <?php endif; ?>
        </div>
    </div>
</div>