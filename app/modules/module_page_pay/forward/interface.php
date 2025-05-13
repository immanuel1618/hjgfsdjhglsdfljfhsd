<?php
if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
} ?>
<div class="row">
    <div class="col-md-12">
        <div class="admin_nav menu_justify">
            <button class="secondary_btn <?= (get_section('section', 'lk') == 'lk' || get_section('section', 'lk') == 'search') ? 'active_btn_adm' : ''; ?>" onclick="location.href = '/pay'">
                <svg viewBox="0 0 640 512">
                    <path d="M320 368C320 427.5 349.5 480.1 394.8 512H64C28.65 512 0 483.3 0 448V224C0 188.7 28.65 160 64 160H448C471.8 160 492.5 172.9 503.5 192.2C501 192.1 498.5 192 496 192C398.8 192 320 270.8 320 368zM440 80C453.3 80 464 90.75 464 104C464 117.3 453.3 128 440 128H72C58.75 128 48 117.3 48 104C48 90.75 58.75 80 72 80H440zM392 0C405.3 0 416 10.75 416 24C416 37.25 405.3 48 392 48H120C106.7 48 96 37.25 96 24C96 10.75 106.7 0 120 0H392zM640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368zM528.6 416H463.4C442.4 416 424.5 429.7 418.3 448.7C438.5 468.1 465.8 480 496 480C526.2 480 553.5 468.1 573.7 448.7C567.5 429.7 549.6 416 528.6 416zM496 288C469.5 288 448 309.5 448 336C448 362.5 469.5 384 496 384C522.5 384 544 362.5 544 336C544 309.5 522.5 288 496 288z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_UsersList') ?>
            </button>
            <button class="secondary_btn <?php get_section('section', 'lk') == 'gateways' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'gateways') ?>'">
                <svg viewBox="0 0 640 512">
                    <path d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64H337.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64zm64 64H96v64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64h64V320zM320 352c53 0 96-43 96-96s-43-96-96-96s-96 43-96 96s43 96 96 96z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_SettingsGateways') ?>
            </button>
            <button class="secondary_btn <?php get_section('section', 'lk') == 'promocodes' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'promocodes') ?>'">
                <svg viewBox="0 0 512 512">
                    <path d="M256 0C292.8 0 324.8 20.7 340.9 51.1C373.8 40.1 410.1 48.96 437 74.98C463 101 470.1 138.2 460.9 171.1C491.3 187.2 512 219.2 512 256C512 292.8 491.3 324.8 460.9 340.9C471 373.8 463 410.1 437 437C410.1 463 373.8 470.1 340.9 460.9C324.8 491.3 292.8 512 256 512C219.2 512 187.2 491.3 171.1 460.9C138.2 471 101 463 74.98 437C48.96 410.1 41 373.8 51.1 340.9C20.7 324.8 0 292.8 0 256C0 219.2 20.7 187.2 51.1 171.1C40.1 138.2 48.96 101 74.98 74.98C101 48.96 138.2 41 171.1 51.1C187.2 20.7 219.2 0 256 0V0zM192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224zM320 288C302.3 288 288 302.3 288 320C288 337.7 302.3 352 320 352C337.7 352 352 337.7 352 320C352 302.3 337.7 288 320 288zM336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L336.1 208.1z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?>
            </button>
            <button class="secondary_btn <?php get_section('section', 'lk') == 'payments' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'payments') ?>'">
                <svg viewBox="0 0 512 512">
                    <path d="M256 0C292.8 0 324.8 20.7 340.9 51.1C373.8 40.1 410.1 48.96 437 74.98C463 101 470.1 138.2 460.9 171.1C491.3 187.2 512 219.2 512 256C512 292.8 491.3 324.8 460.9 340.9C471 373.8 463 410.1 437 437C410.1 463 373.8 470.1 340.9 460.9C324.8 491.3 292.8 512 256 512C219.2 512 187.2 491.3 171.1 460.9C138.2 471 101 463 74.98 437C48.96 410.1 41 373.8 51.1 340.9C20.7 324.8 0 292.8 0 256C0 219.2 20.7 187.2 51.1 171.1C40.1 138.2 48.96 101 74.98 74.98C101 48.96 138.2 41 171.1 51.1C187.2 20.7 219.2 0 256 0V0zM192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224zM320 288C302.3 288 288 302.3 288 320C288 337.7 302.3 352 320 352C337.7 352 352 337.7 352 320C352 302.3 337.7 288 320 288zM336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L336.1 208.1z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_pay', '_PaymentsList') ?>
            </button>
        </div>
    </div>
</div>
<?php if (!empty($_GET['section']) && isset($_SESSION['steamid32'])) : ?>
    <div class="row">
        <?php switch ($_GET['section']):
            case $_GET['section']:
                require MODULES . 'module_page_pay/includes/' . $_GET['section'] . '.php';
                break;
        endswitch; ?>
    </div>
<?php else : ?>
    <div class="row">
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
    </div>
    <?php if (!empty($_GET['user_edit'])) : $user = $LK->LkGetUserData($_GET['user_edit']);
        $pays = $LK->LkGetUserPays($_GET['user_edit']); ?>
        <div class="row">
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
        </div>
    <?php endif ?>
<?php endif; ?>