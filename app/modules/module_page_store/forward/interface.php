<script>
    let server = <?= array_key_first($servers) ?? 0 ?>
</script>
<?php
if (isset($_SESSION['user_admin'])) : ?>
    <?php if ($General->arr_general['theme'] == "neo") : ?>
        <div class="row">
            <div class="col-md-12">
                <div class="admin_nav">
                    <button class="secondary_btn <?php get_section('section', 'store') == 'store' && print 'active_btn_adm' ?>" onclick="location.href = window.location.pathname;">
                        <svg viewBox="0 0 576 512">
                            <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_main') ?>
                    </button>
                    <button class="secondary_btn <?php get_section('section', 'store') == 'options' && print 'active_btn_adm' ?>" onclick="location.href = '?page=store&section=options';">
                        <svg viewBox="0 0 640 512">
                            <path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.7 8.4 166.9 8 160 8s-13.7 .4-20.4 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM208 176c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 400c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_options_shop') ?>
                    </button>
                    <button class="secondary_btn <?php get_section('section', 'store') == 'logs' && print 'active_btn_adm' ?>" onclick="location.href = '?page=shop&section=logs';">
                        <svg viewBox="0 0 576 512">
                            <path d="M304 16.58C304 7.555 310.1 0 320 0C443.7 0 544 100.3 544 224C544 233 536.4 240 527.4 240H304V16.58zM32 272C32 150.7 122.1 50.34 238.1 34.25C248.2 32.99 256 40.36 256 49.61V288L412.5 444.5C419.2 451.2 418.7 462.2 411 467.7C371.8 495.6 323.8 512 272 512C139.5 512 32 404.6 32 272zM558.4 288C567.6 288 575 295.8 573.8 305C566.1 360.9 539.1 410.6 499.9 447.3C493.9 452.1 484.5 452.5 478.7 446.7L320 288H558.4z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_buyLogs') ?>
                    </button>
                    <button class="secondary_btn <?php get_section('section', 'store') == 'errors' && print 'active_btn_adm' ?>" onclick="location.href = '?page=shop&section=errors';">
                        <svg viewBox="0 0 448 512">
                            <path d="M352 0v96h96L352 0zM320 96V0H144C117.5 0 96 21.49 96 48v320C96 394.5 117.5 416 144 416h256c26.51 0 48-21.49 48-48V128h-96C334.4 128 320 113.6 320 96zM328 512h-208C53.83 512 0 458.2 0 392v-272C0 106.8 10.75 96 24 96S48 106.8 48 120v272c0 39.7 32.3 72 72 72h208c13.25 0 24 10.75 24 24S341.3 512 328 512z"></path>
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_errorLog') ?>
                    </button>
                </div>
            </div>
        </div>
    <?php elseif ($General->arr_general['theme'] == "rich") : ?>
        <aside class="sidebar-right unshow">
            <section class="sidebar">
                <div class="user-sidebar-right-block">
                    <div class="info">
                        <div class="admin_type">
                            <svg viewBox="0 0 512 512">
                                <path d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM104 432c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="menu">
                    <ul class="nav">
                        <li data-tippy-placement="left" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_main') ?>" <?php get_section('section', 'store') == 'store' && print 'class="active_m"' ?> onclick="location.href=window.location.pathname;">
                            <svg viewBox="0 0 576 512">
                                <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                            </svg>
                        </li>
                        <li data-tippy-placement="left" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_options_shop') ?>" <?php get_section('section', 'store') == 'options' && print 'class="active_m"' ?> onclick="location.href = '?page=shop&section=options';">
                            <svg viewBox="0 0 640 512">
                                <path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.7 8.4 166.9 8 160 8s-13.7 .4-20.4 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM208 176c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 400c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
                            </svg>
                        </li>
                        <li data-tippy-placement="left" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_buyLogs') ?>" <?php get_section('section', 'store') == 'logs' && print 'class="active_m"' ?> onclick="location.href = '?page=shop&section=logs';">
                            <svg viewBox="0 0 576 512">
                                <path d="M304 16.58C304 7.555 310.1 0 320 0C443.7 0 544 100.3 544 224C544 233 536.4 240 527.4 240H304V16.58zM32 272C32 150.7 122.1 50.34 238.1 34.25C248.2 32.99 256 40.36 256 49.61V288L412.5 444.5C419.2 451.2 418.7 462.2 411 467.7C371.8 495.6 323.8 512 272 512C139.5 512 32 404.6 32 272zM558.4 288C567.6 288 575 295.8 573.8 305C566.1 360.9 539.1 410.6 499.9 447.3C493.9 452.1 484.5 452.5 478.7 446.7L320 288H558.4z" />
                            </svg>
                        </li>
                        <li data-tippy-placement="left" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_errorLog') ?>" <?php get_section('section', 'store') == 'errors' && print 'class="active_m"' ?> onclick="location.href = '?page=shop&section=errors';">
                            <svg viewBox="0 0 448 512">
                                <path d="M352 0v96h96L352 0zM320 96V0H144C117.5 0 96 21.49 96 48v320C96 394.5 117.5 416 144 416h256c26.51 0 48-21.49 48-48V128h-96C334.4 128 320 113.6 320 96zM328 512h-208C53.83 512 0 458.2 0 392v-272C0 106.8 10.75 96 24 96S48 106.8 48 120v272c0 39.7 32.3 72 72 72h208c13.25 0 24 10.75 24 24S341.3 512 328 512z"></path>
                            </svg>
                        </li>
                    </ul>
                </div>
            </section>
        </aside>
    <?php endif; ?>
<?php endif; ?>
<?php if (!empty($_GET['section']) && ($_GET['section'] === 'basket' || $_GET['section'] === 'payment' || $_GET['section'] === 'payment_logs')) :
    require MODULES . 'module_page_store/includes/' . $_GET['section'] . '.php';
elseif (!empty($_GET['section']) && isset($_SESSION['user_admin'])) : ?>
    <div class="row">
        <?php require MODULES . 'module_page_store/includes/' . $_GET['section'] . '.php'; ?>
    </div>
<?php else : ?>

    <div class="row">
        <div class="col-md-12">
            <div class="filter_choosing_server_cat">
                <div class="choosing_text">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_ServerProducts') ?> <span id="name_server"><?= $servers[array_key_first($servers)]['name']; ?></span>
                </div>
                <?php if (!empty($categories)) : ?>
                    <div class="categories">
                        <button class="categories_btn categories_btn_reset shop_cat_0 shop_cat_active" onclick="showCategory(0)" data-value="0">
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <g data-name="Layer 2">
                                        <path d="M22 2.75H2a1.25 1.25 0 0 0 0 2.5h20a1.25 1.25 0 0 0 0-2.5zM22 10.75H2a1.25 1.25 0 0 0 0 2.5h20a1.25 1.25 0 0 0 0-2.5zM22 18.75H2a1.25 1.25 0 0 0 0 2.5h20a1.25 1.25 0 0 0 0-2.5z"></path>
                                        <circle cx="17" cy="4" r="3.75"></circle>
                                        <circle cx="10" cy="12" r="3.75"></circle>
                                        <circle cx="17" cy="20" r="3.75"></circle>
                                    </g>
                                </g>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_store', '_notSelected') ?>
                        </button>
                        <?php foreach ($categories as $key => $cat) : ?>
                            <button class="categories_btn shop_cat_<?= $cat['id'] ?>" onclick="showCategory(<?= $cat['id'] ?>)" data-value="<?= $cat['id']; ?>">
                                <svg x="0" y="0" viewBox="0 0 49.94 49.94" xml:space="preserve">
                                    <g>
                                        <path d="M48.856 22.73a3.56 3.56 0 0 0 .906-3.671 3.56 3.56 0 0 0-2.892-2.438l-12.092-1.757a1.58 1.58 0 0 1-1.19-.865L28.182 3.043a3.56 3.56 0 0 0-3.212-1.996 3.56 3.56 0 0 0-3.211 1.996L16.352 14c-.23.467-.676.79-1.191.865L3.069 16.622A3.56 3.56 0 0 0 .177 19.06a3.56 3.56 0 0 0 .906 3.671l8.749 8.528c.373.364.544.888.456 1.4L8.224 44.701a3.506 3.506 0 0 0 .781 2.904c1.066 1.267 2.927 1.653 4.415.871l10.814-5.686a1.619 1.619 0 0 1 1.472 0l10.815 5.686a3.544 3.544 0 0 0 1.666.417c1.057 0 2.059-.47 2.748-1.288a3.505 3.505 0 0 0 .781-2.904l-2.065-12.042a1.582 1.582 0 0 1 .456-1.4l8.749-8.529z"></path>
                                    </g>
                                </svg>
                                <?= $cat['name'] ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row shop_bk row_reverse">
        <div class="col-md-9">
            <div class="shop_wrapper_product" style="grid-template-columns: repeat(auto-fill, minmax(<?= ($options['column_count'] == 3) ? "17em" : "16em" ?>, 1fr)) !important;">
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['status'] || isset($_SESSION['user_admin'])) : ?>
                        <div class="shop_product_wrapper shop_product_server_<?= $product['server_id'] ?> shop_product_cat_<?= $product['category'] ?> shop_card_wrapper shop_card_wrapper_<?= $product['id'] ?>" data-server="<?= $product['server_id'] ?>" data-category="<?= $product['category'] ?>" style="<?= isset(current($servers)['id']) && current($servers)['id'] != $product['server_id'] ? 'display:none' : '' ?>">
                            <div class="shop_product" id="shop_product_<?= $product['id'] ?>" data-type="<?= $product['type'] ?>" data-price-value="<?= $options['amount_value'] ?>">
                                <?php if (!empty($product['badge'])) : ?>
                                    <div class="shop_badge"><?= $product['badge'] ?></div>
                                <?php endif; ?>
                                <div class="shop_header">
                                    <?php if (!empty($product['img']) && preg_match("/\.webm$/", $product['img'])): ?>
                                        <video preload="auto" class="shop_product_img back_video" id="back_video" playsinline="" muted="" loop="">
                                            <source src="<?= $General->arr_general['site'] . 'app/modules/module_page_store/assets/img/' . $product['img'] ?>" type="video/webm">
                                        </video>
                                    <?php else: ?>
                                        <img class="shop_product_img" src="<?= !empty($product['img']) ? $General->arr_general['site'] . 'app/modules/module_page_store/assets/img/' . $product['img'] : $General->arr_general['site'] . 'app/modules/module_page_store/assets/img/no.png' ?>" onerror="this.src='<?= $General->arr_general['site'] ?>app/modules/module_page_store/assets/img/no.png'" alt="">
                                    <?php endif; ?>
                                    <?php if ($product['title_show']) : ?>
                                        <div class="shop_product_title">
                                            <p class="shop_product_gradient_text shop_product_title_<?= $product['id'] ?> shop_product_gradient_<?= $product['id'] ?>"><?= $product['title'] ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="shop_product_select_title" data-value="0" id="select_price_title_<?= $product['id'] ?>" onclick="togglePrice(<?= $product['id'] ?>)">
                                    <?php
                                    $priceOption = $prices[$product['id']][0] ?? [];
                                    $discount = 100 - (!isset($discounts[$product['id']]) ? 0 : $discounts[$product['id']] + $discounts[-1]);
                                    $firstDiscountPrice = round(!isset($priceOption['price']) ? 0 : $priceOption['price'] / 100 * $discount);
                                    $firstWithoutDiscountPrice = round(!isset($priceOption['price']) ? 0 : $priceOption['price']);
                                    $title = $OptionPrice->prepareOptionsToTitle($product['type'], $product['title'], $priceOption['options'] ?? []);
                                    ?>
                                    <input type="hidden" id="input_price_<?= $product['id'] ?>" name="price" value="<?= $priceOption['id'] ?? 0 ?>">
                                    <?php if (!empty($priceOption)) : ?>
                                        <div class="shop_product_select_title_text" id="select_title_<?= $product['id'] ?>">
                                            <?= $title; ?> -
                                            <span class="shop_product_color_value_<?= $product['id'] ?>"><?= ' ' . $firstDiscountPrice; ?> <?= $options['amount_value'] ?></span>
                                        </div>
                                        <div class="shop_product_select_button shop_product_color_value_<?= $product['id'] ?>">
                                            <svg id="select_price_icon_<?= $product['id'] ?>" viewBox="0 0 448 512">
                                                <path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                            </svg>
                                        </div>
                                    <?php elseif (isset($_SESSION['user_admin'])) : ?>
                                        <div onclick="showAddPriceTable(<?= $product['id'] ?>)">
                                            <?= $Translate->get_translate_module_phrase('module_page_store', '_shopAddCost') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="shop_product_select no-scrollbar" id="select_price_<?= $product['id'] ?>" style="display:none">
                                        <?php foreach ($prices[$product['id']] ?? [] as $price) :
                                            $title = $OptionPrice->prepareOptionsToTitle($product['type'], $product['title'], $price['options'] ?? []);
                                            $discount = 100 - (!isset($discounts[$product['id']]) ? 0 : $discounts[$product['id']] + $discounts[-1]);
                                            $priceWithDiscount = round(!isset($price['price']) ? 0 : $price['price'] / 100 * $discount);
                                            $priceWithoutDiscount = round(!isset($price['price']) ? 0 : $price['price']);
                                        ?>
                                            <div class="shop_product_option" data-price="<?= $priceWithDiscount ?>" data-price_old="<?= $priceWithoutDiscount ?>" data-value="<?= $options['amount_value'] ?>" id="option_price_<?= $product['id'] ?>_<?= $price['id'] ?>" onclick="setPrice(<?= $product['id'] ?>, <?= $price['id'] ?>)">
                                                <span class="shop_price_title"><?= $title; ?> - </span>
                                                <span class="shop_price_title_value">
                                                    <span class="shop_product_color_value_<?= $product['id'] ?>">
                                                        <?= $priceWithDiscount ?><?= $options['amount_value'] ?>
                                                    </span>
                                                </span>
                                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                                    <div class="shop_delete_server shop_product_price_delete" onclick="sendAjax('delete-price-options', <?= $price['id'] ?>)">
                                                        <svg viewBox="0 0 320 512">
                                                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                                        </svg>
                                                    </div>
                                                    <div class="shop_edit_server shop_product_price_edit" onclick="sendAjax('edit-ajax-price-options', <?= $price['id'] ?>)">
                                                        <svg viewBox="0 0 512 512">
                                                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if (isset($_SESSION['user_admin'])) : ?>
                                            <div class="shop_table_create_button_option" onclick="showAddPriceTable(<?= $product['id'] ?>)">
                                                <?= $Translate->get_translate_module_phrase('module_page_store', '_shopNewPrice') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <center>
                                    <div class="shop_product_description">
                                        <?= $Translate->get_translate_module_phrase('module_page_store', '_productAdvantages') ?>
                                        <?php if ($product['table_status']) : ?>
                                            <div data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_store', '_allAdvantages') ?>" data-tippy-placement="top" class="shop_product_button_info shop_product_gradient_background_<?= $product['id'] ?>" onclick="sendAjax('get-ajax-table', <?= $product['id'] ?>)">
                                                <?= $Translate->get_translate_module_phrase('module_page_store', '_shopShowAll') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </center>
                                <div class="shop_product_properties scroll" <?= ($options['extend_cards'] == 1) ? "style='max-height: max-content; overflow: auto;'" : "" ?>>
                                    <?php foreach ($properties[$product['id']] ?? [] as $item) :
                                        $className = $item['active'] ? '' : 'shop_product_property_disabled'; ?>
                                        <form id="edit-card-property_<?= $item['id'] ?>" data-sort="<?= $item['sort'] ?>" class="shop_product_property <?= $className; ?> shop_card_property">
                                            <?php if (isset($_SESSION['user_admin'])) : ?>
                                                <div class="shop_sort_property">
                                                    <input type="number" name="sort" min="1" value="<?= $item['sort'] ?>" readonly />
                                                </div>
                                                <div class="shop_delete_server shop_product_price_delete" onclick="sendAjax('delete-card-property', <?= $item['id'] ?>)">
                                                    <svg viewBox="0 0 320 512">
                                                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                                    </svg>
                                                </div>
                                                <div class="shop_edit_server shop_product_price_edit" onclick="changePropertyField(<?= $item['id'] ?>, 'card')">
                                                    <svg viewBox="0 0 512 512">
                                                        <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div class="shop_product_property_icon shop_product_gradient_<?= $product['id'] ?>">
                                                <?php if ($item['active']) : ?>
                                                    <svg x="0" y="0" viewBox="0 0 442.533 442.533" xml:space="preserve">
                                                        <g>
                                                            <path d="m434.539 98.499-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993-7.618 0-14.093 2.665-19.417 7.993L169.59 247.248l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992-7.616 0-14.087 2.662-19.417 7.992L7.994 201.852C2.664 207.181 0 213.654 0 221.269c0 7.609 2.664 14.088 7.994 19.416l103.351 103.349 38.831 38.828c5.327 5.332 11.8 7.994 19.414 7.994 7.611 0 14.084-2.669 19.414-7.994l38.83-38.828L434.539 137.33c5.325-5.33 7.994-11.802 7.994-19.417.004-7.611-2.669-14.084-7.994-19.414z"></path>
                                                        </g>
                                                    </svg>
                                                <?php else : ?>
                                                    <svg class="property_icon_dsb" x="0" y="0" viewBox="0 0 174.239 174.239" xml:space="preserve">
                                                        <g>
                                                            <path d="M146.537 1.047a3.6 3.6 0 0 0-5.077 0L89.658 52.849a3.6 3.6 0 0 1-5.077 0L32.78 1.047a3.6 3.6 0 0 0-5.077 0L1.047 27.702a3.6 3.6 0 0 0 0 5.077l51.802 51.802a3.6 3.6 0 0 1 0 5.077L1.047 141.46a3.6 3.6 0 0 0 0 5.077l26.655 26.655a3.6 3.6 0 0 0 5.077 0l51.802-51.802a3.6 3.6 0 0 1 5.077 0l51.801 51.801a3.6 3.6 0 0 0 5.077 0l26.655-26.655a3.6 3.6 0 0 0 0-5.077L121.39 89.658a3.6 3.6 0 0 1 0-5.077l51.801-51.801a3.6 3.6 0 0 0 0-5.077L146.537 1.047z"></path>
                                                        </g>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="shop_product_property_title"><?= $item['title'] ?></div>
                                        </form>
                                    <?php endforeach ?>
                                    <div class="shop_card_fix_<?= $product['id'] ?>"></div>
                                    <?php if (isset($_SESSION['user_admin'])) : ?>
                                        <div class="shop_table_create_button" onclick="createPropertyFields(<?= $product['id'] ?>, 'card')">
                                            <?= $Translate->get_translate_module_phrase('module_page_store', '_shopAddadvantage') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="shop_flex_row">
                                    <div class="shop_buy_price">
                                        <div class="shop_product_description_price" id="shop_product_description_price_<?= $product['id'] ?>">
                                            <div class="shop_product_price" id="shop_product_price_<?= $product['id'] ?>">
                                                <span class="shop_product_price_count"><?= $firstDiscountPrice ?></span>
                                                <span class="shop_product_price_value"><?= $options['amount_value'] ?></span>
                                                <?php if ($firstDiscountPrice != $firstWithoutDiscountPrice) : ?>
                                                    <span class="shop_product_price_old"><?= $firstWithoutDiscountPrice ?> <?= $options['amount_value'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if ($discounts[$product['id']] || $discounts[-1] > 0) : ?>
                                            <div class="shop_discount_icon" data-discount="<?= !isset($discounts[$product['id']]) ? 0 : $discounts[$product['id']] + $discounts[-1] ?>">
                                                - <?= !isset($discounts[$product['id']]) ? 0 : $discounts[$product['id']] + $discounts[-1] ?> %
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="shop_product_button shop_product_gradient_background_<?= $product['id'] ?>" onclick="sendAjax('add-product-basket', $('#input_price_<?= $product['id'] ?>').val())">
                                        <svg viewBox="0 0 576 512">
                                            <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20h44v44c0 11 9 20 20 20s20-9 20-20V180h44c11 0 20-9 20-20s-9-20-20-20H356V96c0-11-9-20-20-20s-20 9-20 20v44H272c-11 0-20 9-20 20z"></path>
                                        </svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_store', '_addBasket') ?>
                                    </div>

                                </div>
                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <form id="delete-product">
                                        <div class="shop_delete_product shop_delete_server" data-openmodal="delete-prod-modal-<?= $product['id']; ?>">
                                            <svg viewBox="0 0 320 512">
                                                <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                            </svg>
                                        </div>
                                    </form>
                                    <form id="edit-ajax-product">
                                        <div class="shop_delete_product shop_edit_server" onclick="sendAjax('edit-ajax-product', '<?= $product['id']; ?>')">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                            </svg>
                                        </div>
                                    </form>
                                    <div class="popup_modal" id="delete-prod-modal-<?= $product['id']; ?>">
                                        <div class="popup_modal_content no-close no-scrollbar">
                                            <div class="popup_modal_head">
                                                <?= $Translate->get_translate_module_phrase('module_page_store', '_Confirmation') ?>
                                                <span class="popup_modal_close">
                                                    <svg viewBox="0 0 320 512">
                                                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="accept_content"><?= $Translate->get_translate_module_phrase('module_page_store', '_del_prod') ?></div>
                                            <div class="shop_accetp_buttons">
                                                <div class="secondary_btn" onclick="sendAjax('delete-product', '<?= $product['id']; ?>')"><?= $Translate->get_translate_module_phrase('module_page_store', '_Yes') ?></div>
                                                <div class="secondary_btn btn_delete popup_modal_close"><?= $Translate->get_translate_module_phrase('module_page_store', '_No') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php require MODULES . "module_page_store/includes/styles/product_style.php" ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!empty($servers) && isset($_SESSION['user_admin'])) : ?>
                    <div class="shop_card_wrapper shop_add_card" onclick="showShopTable('shop_table_add_card')">
                        <div class="shop_card">
                            <div class="add_new_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_addProduct') ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-3 shop_servers_wrap_area">
            <?php if (isset($_SESSION['steamid32'])) : ?>
                <div class="button_to_buy" onclick="location.href = '?section=basket';">
                    <svg viewBox="0 0 576 512">
                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_basketOfShop') ?>
                    <?php if (isset($_SESSION['steamid32'])) {
                        $basket = count($Basket->findBySteam($_SESSION['steamid32'])['basket']);
                    } else {
                        $basket = 0;
                    } ?>
                    <div class="count_basket"><?= $basket ?></div>
                </div>
            <?php endif; ?>
            <?php foreach ($servers as $key => $server) : ?>
                <div onclick="showCatalog(<?= $server['id'] ?>)" data-value="<?= $server['id']; ?>" class="shop_server shop_button_servers shop_server_<?= $server['id'] ?> <?php if (array_key_first($servers) === $key) echo 'shop_server_active'; ?>">
                    <?php if (isset($_SESSION['user_admin'])) : ?>
                        <form id="delete-server">
                            <div class="shop_delete_server" data-openmodal="delete-srv-modal-<?= $server['id'] ?>">
                                <svg viewBox="0 0 320 512">
                                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                </svg>
                            </div>
                        </form>
                        <form id="edit-ajax-server">
                            <div class="shop_edit_server" onclick="sendAjax('edit-ajax-server', '<?= $server['id']; ?>')">
                                <svg viewBox="0 0 512 512">
                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                </svg>
                            </div>
                        </form>
                    <?php endif; ?>
                    <?= $server['name']; ?>
                </div>
                <div class="popup_modal" id="delete-srv-modal-<?= $server['id']; ?>">
                    <div class="popup_modal_content no-close no-scrollbar">
                        <div class="popup_modal_head">
                            <?= $Translate->get_translate_module_phrase('module_page_store', '_Confirmation') ?>
                            <span class="popup_modal_close">
                                <svg viewBox="0 0 320 512">
                                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="accept_content"><?= $Translate->get_translate_module_phrase('module_page_store', '_del_server') ?></div>
                        <div class="shop_accetp_buttons">
                            <div class="secondary_btn" onclick="sendAjax('delete-server', '<?= $server['id']; ?>')"><?= $Translate->get_translate_module_phrase('module_page_store', '_Yes') ?></div>
                            <div class="secondary_btn btn_delete popup_modal_close"><?= $Translate->get_translate_module_phrase('module_page_store', '_No') ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (isset($_SESSION['user_admin'])) : ?>
                <div class="shop_add_server shop_button_servers" onclick="showShopTable('shop_table_add_server')">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_addingServer') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="shop_black_screen" style="display: <?= $options['use_server_accept'] ? 'block' : 'none' ?>"></div>
<?php
    require MODULES . 'module_page_store/includes/tables/show_properties.php';
    require MODULES . 'module_page_store/includes/tables/servers_confirm.php';

    if (isset($_SESSION['user_admin'])) {
        require MODULES . 'module_page_store/includes/tables/add_price.php';
        require MODULES . 'module_page_store/includes/tables/edit_price.php';
        require MODULES . 'module_page_store/includes/tables/add_server.php';
        require MODULES . 'module_page_store/includes/tables/edit_server.php';
        require MODULES . 'module_page_store/includes/tables/add_product.php';
        require MODULES . 'module_page_store/includes/tables/edit_product.php';
    }
endif; ?>