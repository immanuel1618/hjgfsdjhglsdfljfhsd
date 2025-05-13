<?php

if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}
?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="badge">
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_UsersList') ?>
            </div>
        </div>
        <div class="card-container">
            <div class="modern_table">
                <div class="mt_header_1">
                    <li>
                        <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_pay', '_LK_avatar') ?></span>
                        <span><?= $Translate->get_translate_phrase('_Player') ?></span>
                        <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_Balance') ?></span>
                        <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_pay', '_BalanceAllTime') ?></span>
                        <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                    </li>
                </div>
                <div class="mt_content_1 mb20 no-scrollbar">
                    <?php foreach ($playersAll as $key) : ?>
                        <li>
                            <span class="none_span">
                                <?php $General->get_js_relevance_avatar($key['auth']) ?>
                                <img class="rounded-circle" src="<?= $General->getAvatar(con_steam64($key['auth']), 2); ?>" id="avatar" avatarid="<?= con_steam64($key['auth']) ?>">
                            </span>
                            <span onclick="location.href = '<?= $General->arr_general['site'] ?>profiles/<?= $key['auth'] ?>?search=1'">
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= con_steam64($key['auth']) ?>?search=1"><?= action_text_clear(action_text_trim($General->checkName(con_steam64($key['auth'])), 16)) ?></a>
                            </span>
                            <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?> <?= $key['cash'] ?></span>
                            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?> <?= $key['all_cash'] ?></span>
                            <span>
                                <a title="" href="<?= set_url_section(get_url(2), 'user_edit', $key['auth']) ?>">
                                    <?= $Translate->get_translate_phrase('_Change') ?>
                                </a>
                            </span>
                        </li>
                    <?php endforeach; ?>
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
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="badge" style="justify-content: space-between;">
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_Options') ?>
                <form data-get="user_edit" id="users_clean" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="users_clean">
                </form>
                <button class="secondary_btn btn_delete" type="submit" form="users_clean" style="position: absolute; right: 20px;"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ClearZero') ?></button>
            </div>
        </div>
        <div class="card-container">
            <div>
                <form id="search_users" data-default="true" enctype="multipart/form-data" method="post">
                    <div class="input-form">
                        <input name="search_users" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/... ">
                    </div>
                </form>
                <button class="secondary_btn" type="submit" form="search_users"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Search') ?></button>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($_GET['user_edit'])) : $user = $LK->LkGetUserData($_GET['user_edit']);
    $pays = $LK->LkGetUserPays($_GET['user_edit']); ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Information') ?> - <?= $General->checkName(con_steam64($user[0]['auth'])) ?><a data-del="delete" data-get="user_edit" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
            </div>
            <div class="card-container module_block">
                <form id="user_edit" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="user" value="<?= $_GET['user_edit'] ?>">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Balance') ?></div>
                        <input type="hidden" name="old_balance" value="<?= $user[0]['cash'] ?>">
                        <input name="new_balance" value="<?= $user[0]['cash'] ?>">
                    </div>
                </form>
                <input class="secondary_btn" type="submit" form="user_edit" value="<?= $Translate->get_translate_module_phrase('module_page_pay', '_Save') ?>">
                <div class="user_pays">
                    <?php if (!empty($pays)) : ?>
                        <div class="modern_table">
                            <div class="mt_header_2">
                                <li>
                                    <span class="none_span">#</span>
                                    <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_Date') ?></span>
                                    <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Gateways') ?></span>
                                    <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_Amount') ?></span>
                                    <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?></span>
                                    <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_Status') ?></span>
                                </li>
                            </div>
                            <div class="mt_content_2 no-scrollbar">
                                <?php foreach ($pays as $key) : ?>
                                    <li>
                                        <span class="none_span"><?= $key['pay_order'] ?></span>
                                        <span><?= $key['pay_data'] ?></span>
                                        <span class="none_span"><img src="<?= $General->arr_general['site'] ?>app/modules/module_page_pay/assets/gateways/<?= mb_strtolower($key['pay_system']) ?>.svg"></span>
                                        <span><?= $key['pay_summ'] ?></span>
                                        <span class="none_span"><?= $key['pay_promo'] ?></span>
                                        <span><?= $LK->status($key['pay_status']) ?></span>
                                    </li>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="block_last_donate_nope">
                            <svg viewBox="0 0 512 512">
                                <path d="M0 256C0 397.4 114.6 512 256 512s256-114.6 256-256S397.4 0 256 0S0 114.6 0 256zm240 80c0-8.8 7.2-16 16-16c45 0 85.6 20.5 115.7 53.1c6 6.5 5.6 16.6-.9 22.6s-16.6 5.6-22.6-.9c-25-27.1-57.4-42.9-92.3-42.9c-8.8 0-16-7.2-16-16zm-80 80c-26.5 0-48-21-48-47c0-20 28.6-60.4 41.6-77.7c3.2-4.4 9.6-4.4 12.8 0C179.6 308.6 208 349 208 369c0 26-21.5 47-48 47zM303.6 208c0-17.7 14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32s-32-14.3-32-32zm-128 32c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z" />
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_pay', '_NotPays') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>