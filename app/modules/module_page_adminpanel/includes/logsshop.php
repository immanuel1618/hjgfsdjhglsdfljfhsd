<div class="col-md-12">
    <select style="display: none;" class="custom-select" onchange="window.location.href=this.value" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_shop'); ?>">
        <option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsweb"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_engine'); ?></option>
        <?php if (file_exists(MODULES . 'module_page_pay/description.json')) : ?>
			<option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logslk"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_pay'); ?></option>
		<?php endif; ?>
        <?php if (file_exists(MODULES . 'module_page_store/description.json')) : ?>
			<option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsshop"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_shop'); ?></option>
		<?php endif; ?>
        <option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsref"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_ref'); ?></option>
    </select>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_LogList'); ?></div>
        </div>
        <div class="card-container">
            <div class="shop_logs_head">
                <span class="logs_hide">
                    <svg viewBox="0 0 512 512">
                        <path d="M105.4 67.08C118.2 44.81 141.1 31.08 167.7 31.08H344.3C370 31.08 393.8 44.81 406.6 67.08L494.9 219.1C507.8 242.3 507.8 269.7 494.9 291.1L406.6 444.9C393.8 467.2 370 480.9 344.3 480.9H167.7C141.1 480.9 118.2 467.2 105.4 444.9L17.07 291.1C4.206 269.7 4.206 242.3 17.07 219.1L105.4 67.08zM158.3 279.8L107.1 335.9L153.9 416.9C156.7 421.9 161.1 424.9 167.7 424.9H344.3C350 424.9 355.3 421.9 358.1 416.9L413.4 321.2L340.7 233.8C336.2 228.3 329.4 225.1 322.3 225.1C315.2 225.1 308.4 228.3 303.8 233.8L232.2 320L193.3 279.4C188.7 274.6 182.4 271.9 175.7 272C169.1 272.1 162.8 274.9 158.3 279.8V279.8zM192 199.1C214.1 199.1 232 182.1 232 159.1C232 137.9 214.1 119.1 192 119.1C169.9 119.1 152 137.9 152 159.1C152 182.1 169.9 199.1 192 199.1z" />
                    </svg>
                </span>
                <span>NickName</span>
                <span><?= $Translate->get_translate_module_phrase('module_page_store', '_title') ?></span>
                <?php if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) : ?>
                    <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_count') ?></span>
                <?php else: ?>
                    <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_promo') ?></span>
                <?php endif; ?>
                <?php if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) : ?>
                    <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_priceL') ?></span>
                <?php else: ?>
                    <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_status') ?></span>
                <?php endif; ?>
                <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_date') ?></span>
                <span class="logs_hide"><?= $Translate->get_translate_module_phrase('module_page_store', '_status') ?></span>
            </div>
            <ul class="shop_logs_body shop_logs_scroll">
                <?php $count = -1;
                foreach (array_reverse($Admin->ShopLogs(), true) as $log) : $count++;
                    if ($count >= $page_num_min && $count < $page_num_min + PLAYERS_ON_PAGE) :
                        $General->get_js_relevance_avatar(con_steam32to64($log['steam'])) ?>
                        <li class="pointer" onclick="location.href = '<?= $General->arr_general['site'] ?>profiles/<?php print $log['steam'] ?>/0';">
                            <span class="logs_hide"><img class="avatars_fix" id="<?= con_steam64($log['steam']) ?>" src="<?= $General->getAvatar(con_steam64($log['steam']), 2) ?>"></span>
                            <span><a <?php print sprintf('href="' . $General->arr_general['site'] . 'profiles/%s/0"', $log['steam']) ?>><?= action_text_trim($General->checkName(con_steam64($log['steam'])), 20) ?></a></span>
                            <span><?= $log['title'] ?></span>
                            <?php if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) : ?>
                                <span class="logs_hide"><?= $log['count'] ?></span>
                            <?php else: ?>
                                <span class="logs_hide trans_svg"><?php if (empty($log['promo'])) : ?>
                                        <svg viewBox="0 0 320 512">
                                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                        </svg>
                                    <?php else : ?>
                                        <?= $log['promo'] ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                            <?php if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) : ?>
                                <span class="logs_hide"><?= $log['price'] ?></span>
                            <?php else: ?>
                                <span class="logs_hide"><?= $log['status'] ?></span>
                            <?php endif; ?>
                            <span class="logs_hide"><?= $log['date'] ?></span>
                            <span class="logs_hide"><?= $log['status'] ?></span>
                        </li>
                <?php endif;
                endforeach; ?>
            </ul>
        </div>
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