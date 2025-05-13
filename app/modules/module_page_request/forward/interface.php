<script>
    <?php if (isset($_SESSION['language'])) : ?>
        var lang = <?= json_encode($_SESSION['language']) ?>
    <?php endif; ?>
</script>
<?php
/**
 * @author Revolution#7501
 * @design SLAME#7777
 */
if ($RQ->access >= 3) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="admin_nav">
                <button class="fill_width secondary_btn <?php get_section('page', '') == '' && print 'active_btn_adm' ?>" onclick="location.href = '<?php echo $General->arr_general['site'] ?>request/';">
                    <svg viewBox="0 0 576 512">
                        <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                    </svg>
                    <?= $Translate->get_translate_phrase('_Home') ?>
                </button>
                <?php if ($RQ->access >= 10) : ?>
                    <button class="fill_width secondary_btn <?php get_section('page', '') == 'admin' && print 'active_btn_adm' ?>" onclick="location.href = '<?php echo set_url_section(get_url(2), 'page', 'admin') ?>';">
                        <svg viewBox="0 0 640 512">
                            <path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.7 8.4 166.9 8 160 8s-13.7 .4-20.4 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM208 176c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 400c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_General_settings') ?>
                    </button>
                <?php endif; ?>
                <?php if ($RQ->access >= 3) : ?>
                    <button class="fill_width secondary_btn <?php get_section('page', '') == 'list' && print 'active_btn_adm' ?>" onclick="location.href = '<?php echo set_url_section(get_url(2), 'page', 'list') ?>';">
                        <svg viewBox="0 0 448 512">
                            <path d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM128 256C128 238.3 113.7 224 96 224C78.33 224 64 238.3 64 256C64 273.7 78.33 288 96 288C113.7 288 128 273.7 128 256zM128 160C128 142.3 113.7 128 96 128C78.33 128 64 142.3 64 160C64 177.7 78.33 192 96 192C113.7 192 128 177.7 128 160zM128 352C128 334.3 113.7 320 96 320C78.33 320 64 334.3 64 352C64 369.7 78.33 384 96 384C113.7 384 128 369.7 128 352zM192 136C178.7 136 168 146.7 168 160C168 173.3 178.7 184 192 184H352C365.3 184 376 173.3 376 160C376 146.7 365.3 136 352 136H192zM192 232C178.7 232 168 242.7 168 256C168 269.3 178.7 280 192 280H352C365.3 280 376 269.3 376 256C376 242.7 365.3 232 352 232H192zM192 328C178.7 328 168 338.7 168 352C168 365.3 178.7 376 192 376H352C365.3 376 376 365.3 376 352C376 338.7 365.3 328 352 328H192z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_requestsList') ?>
                    </button>
                <?php endif; ?>
                <?php if ($RQ->access >= 8) : ?>
                    <button class="fill_width secondary_btn <?php get_section('page', '') == 'perm' && print 'active_btn_adm' ?>" onclick="location.href = '<?php echo set_url_section(get_url(2), 'page', 'perm') ?>';">
                        <svg viewBox="0 0 512 512">
                            <path d="M466.5 83.71l-192-80c-4.875-2.031-13.16-3.703-18.44-3.703c-5.312 0-13.55 1.672-18.46 3.703L45.61 83.71C27.7 91.1 16 108.6 16 127.1C16 385.2 205.2 512 255.9 512C307.1 512 496 383.8 496 127.1C496 108.6 484.3 91.1 466.5 83.71zM352 200c0 5.531-1.901 11.09-5.781 15.62l-96 112C243.5 335.5 234.6 335.1 232 335.1c-6.344 0-12.47-2.531-16.97-7.031l-48-48C162.3 276.3 160 270.1 160 263.1c0-12.79 10.3-24 24-24c6.141 0 12.28 2.344 16.97 7.031l29.69 29.69l79.13-92.34c4.759-5.532 11.48-8.362 18.24-8.362C346.4 176 352 192.6 352 200z" />
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_SettingAccess') ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($_GET['page'])) : ?>
    <div class="row">
        <?php switch ($_GET['page']) {
            case  'admin':
                require MODULES . 'module_page_request' . '/includes/admin.php';
                break;
            case  'list':
                require MODULES . 'module_page_request' . '/includes/list.php';
                break;
            case  'question':
                require MODULES . 'module_page_request' . '/includes/question.php';
                break;
            case  'review':
                require MODULES . 'module_page_request' . '/includes/review.php';
                break;
            case  'my':
                require MODULES . 'module_page_request' . '/includes/my.php';
                break;
            case  'perm':
                require MODULES . 'module_page_request' . '/includes/permission.php';
                break;
        } ?>
    </div>
    
<?php else : ?>
    <div class="row">
        <div class="col-md-3 req_g">
            <?php if (isset($_SESSION['steamid32'])) : ?>
                <?php if (!empty($myList)) : ?>
                    <div onclick="location.href='<?= $General->arr_general['site'] ?>request/?page=my';" class="secondary_btn mylist_btn">
                        <svg viewBox="0 0 384 512">
                            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16z"></path>
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_MyApplications') ?>
                    </div>
                <?php else : ?>
                    <div style="height: 75px; font-size: 16px; border-radius: 12px;" class="secondary_btn my_requesrt_btn_disabled" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_NoApplications') ?>" data-tippy-placement="bottom">
                        <svg viewBox="0 0 384 512">
                            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16z"></path>
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_MyApplications') ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="requesrt_left_infochoose">
                <span>
                    <svg viewBox="0 0 512 512">
                        <path d="M312 64C327.8 64 342.1 73.3 348.5 87.73C354.1 102.2 352.3 119 341.7 130.8L240 243.8V416C240 428.1 233.2 439.2 222.3 444.6C211.5 450 198.5 448.9 188.8 441.6L124.8 393.6C116.7 387.6 112 378.1 112 368V243.8L10.27 130.8C-.3002 119-2.968 102.2 3.459 87.73C9.885 73.3 24.2 64 39.1 64H312zM480 384C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H352C334.3 448 320 433.7 320 416C320 398.3 334.3 384 352 384H480zM320 256C320 238.3 334.3 224 352 224H480C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H352C334.3 288 320 273.7 320 256zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H416C398.3 128 384 113.7 384 96C384 78.33 398.3 64 416 64H480z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_page_request', '_Applications') ?>
                </span>
                <div class="request_choose_buttons">
                    <?php for ($b = 0; $b < sizeof($requests); $b++) { ?>
                        <a class="request_buttonchoose <?php if (($requests[$b]['id']) == ($requests[$request_id]['id'])) {
                                                            echo 'active_req';
                                                        } ?>" href="<?= set_url_section(get_url(2), 'id', $b) ?>"><?= $requests[$b]['title'] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="badge">
                        <?= empty($requests) ? $Translate->get_translate_module_phrase('module_page_request', '_Applications1')  : $requests[$request_id]['title'] ?>
                    </div>
                </div>
                <div class="card-container">
                    <?php if (empty($requests)) : ?>
                        <div class="empty_request">
                            <svg viewBox="0 0 512 512">
                                <path d="M121 32C91.6 32 66 52 58.9 80.5L1.9 308.4C.6 313.5 0 318.7 0 323.9V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V323.9c0-5.2-.6-10.4-1.9-15.5l-57-227.9C446 52 420.4 32 391 32H121zm0 64H391l48 192H387.8c-12.1 0-23.2 6.8-28.6 17.7l-14.3 28.6c-5.4 10.8-16.5 17.7-28.6 17.7H195.8c-12.1 0-23.2-6.8-28.6-17.7l-14.3-28.6c-5.4-10.8-16.5-17.7-28.6-17.7H73L121 96z" />
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_request', '_NOApplications') ?>
                        </div>
                    <?php else : ?>
                        <form id="request" method="post" class="row__requestform_formblock scroll" onsubmit="SendAjax('#request', 'request', '', '', ''); return false;">
                            <input type="hidden" name="request_id" value="<?= $requests[$request_id]['id'] ?>">
                            <?php if (!empty($requests[$request_id]['discord'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="discord" style="color: #7289d9">
                                            <svg viewBox="0 0 640 512">
                                                <path fill="#7289d9" d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z" />
                                            </svg>
                                            Discord
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_YourDs') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                            </svg>
                                        </span>
                                        <input type="text" name="discord" placeholder="<?= $Translate->get_translate_module_phrase('module_page_request', '_NicknameDS') ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($requests[$request_id]['telegram'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="telegram" style="color: #2AABEE">
                                            <svg viewBox="0 0 496 512">
                                                <path fill="#2AABEE" d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z" />
                                            </svg>
                                            telegram
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_YourTg') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                            </svg>
                                            https://t.me/
                                        </span>
                                        <input type="text" name="telegram" placeholder="<?= $Translate->get_translate_module_phrase('module_page_request', '_NicknameDS') ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($requests[$request_id]['vk'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="vk" style="color: #0077FF">
                                            <svg viewBox="0 0 448 512">
                                                <path fill="#0077FF" d="M31.4907 63.4907C0 94.9813 0 145.671 0 247.04V264.96C0 366.329 0 417.019 31.4907 448.509C62.9813 480 113.671 480 215.04 480H232.96C334.329 480 385.019 480 416.509 448.509C448 417.019 448 366.329 448 264.96V247.04C448 145.671 448 94.9813 416.509 63.4907C385.019 32 334.329 32 232.96 32H215.04C113.671 32 62.9813 32 31.4907 63.4907ZM75.6 168.267H126.747C128.427 253.76 166.133 289.973 196 297.44V168.267H244.16V242C273.653 238.827 304.64 205.227 315.093 168.267H363.253C359.313 187.435 351.46 205.583 340.186 221.579C328.913 237.574 314.461 251.071 297.733 261.227C316.41 270.499 332.907 283.63 346.132 299.751C359.357 315.873 369.01 334.618 374.453 354.747H321.44C316.555 337.262 306.614 321.61 292.865 309.754C279.117 297.899 262.173 290.368 244.16 288.107V354.747H238.373C136.267 354.747 78.0267 284.747 75.6 168.267Z" />
                                            </svg>
                                            vk
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_VKID') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                            </svg>
                                            https://vk.com/
                                        </span>
                                        <input type="text" name="vk" placeholder="VK ID">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- 4 -->
                            <?php foreach ($Question as $key) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="<?= $key['id'] ?>">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                            <?= $key['question'] ?>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <span <?php if (!empty($key['clue'])) : ?> data-tippy-content="<?= $key['clue'] ?>" data-tippy-placement="right" <?php endif; ?>>
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                            </svg>
                                        </span>
                                        <input type="text" name="question<?= $key['id'] ?>" placeholder="<?= $key['desc'] ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (!empty($requests[$request_id]['age_act'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="age">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_request', '_Age') ?>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_realAge') ?>" data-tippy-placement="right">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                            </svg>
                                        </span>
                                        <input type="text" name="age" placeholder="<?= $Translate->get_translate_module_phrase('module_page_request', '_YourAge') ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($requests[$request_id]['server'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_request', '_GameServer') ?>
                                        </div>
                                    </div>
                                    <div class="input_radio_buttons">
                                        <?php foreach ($servers as $key) :
                                            if (in_array($key['id'], $ignore_servers)) :
                                                continue;
                                            endif; ?>
                                            <div class="radio">
                                                <input name="server" type="radio" id="server<?= $key['id'] ?>" value="<?= $key['id']; ?>" <?= ($key['id'] == $requests[$request_id]['default_server']) ? "checked" : ""; ?>>
                                                <label class="custom-radio" for="server<?= $key['id'] ?>"><?= $key['name']; ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($requests[$request_id]['rules'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="rules">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_request', '_FamiliarServerRules') ?>
                                        </div>
                                    </div>
                                    <div class="input_radio_buttons">
                                        <div class="radio">
                                            <input name="rules" type="radio" id="rules0" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_NotFamiliar') ?>" checked>
                                            <label class="custom-radio" for="rules0"><?= $Translate->get_translate_module_phrase('module_page_request', '_NotFamiliar') ?></label>
                                        </div>
                                        <div class="radio">
                                            <input name="rules" type="radio" id="rules1" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_Familiar') ?>">
                                            <label class="custom-radio" for="rules1"><?= $Translate->get_translate_module_phrase('module_page_request', '_Familiar') ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($requests[$request_id]['criteria'])) : ?>
                                <div class="input-container">
                                    <div class="input-form">
                                        <div class="input_text" for="criteria">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                            <?= $Translate->get_translate_module_phrase('module_page_request', '_FamiliarCriteria') ?>
                                        </div>
                                    </div>
                                    <div class="input_radio_buttons">
                                        <div class="radio">
                                            <input name="criteria" type="radio" id="criteria0" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_NotFamiliar') ?>" checked>
                                            <label class="custom-radio" for="criteria0"><?= $Translate->get_translate_module_phrase('module_page_request', '_NotFamiliar') ?></label>
                                        </div>
                                        <div class="radio">
                                            <input name="criteria" type="radio" id="criteria1" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_Familiar') ?>">
                                            <label class="custom-radio" for="criteria1"><?= $Translate->get_translate_module_phrase('module_page_request', '_Familiar') ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                        <div class="row__requestform_buttons">
                            <?php if (!empty($_SESSION['steamid'])) : ?>
                                <input class="secondary_btn btn_request" form="request" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_SendRequest') ?>">
                                <input class="secondary_btn btn_delete btn_request" form="request" type="reset" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_ChangedMyMind') ?>">
                            <?php else : ?>
                                <button class="secondary_btn w100" onclick="location.href='?auth=login'"><?= $Translate->get_translate_module_phrase('module_page_request', '_Auth') ?></button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="badge">
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_Info') ?>
                    </div>
                </div>
                <div class="card-container">
                    <?php if (empty($requests)) : ?>
                        <div class="empty_request">
                            <svg viewBox="0 0 576 512">
                                <path d="M0 64C0 28.65 28.65 0 64 0H320C355.3 0 384 28.65 384 64V198.6C310.1 219.5 256 287.4 256 368C256 427.1 285.1 479.3 329.7 511.3C326.6 511.7 323.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM80 160H304C312.8 160 320 152.8 320 144C320 135.2 312.8 128 304 128H80C71.16 128 64 135.2 64 144C64 152.8 71.16 160 80 160zM80 224C71.16 224 64 231.2 64 240C64 248.8 71.16 256 80 256H240C248.8 256 256 248.8 256 240C256 231.2 248.8 224 240 224H80zM80 320C71.16 320 64 327.2 64 336C64 344.8 71.16 352 80 352H176C184.8 352 192 344.8 192 336C192 327.2 184.8 320 176 320H80zM288 368C288 288.5 352.5 224 432 224C511.5 224 576 288.5 576 368C576 447.5 511.5 512 432 512C352.5 512 288 447.5 288 368zM432 320C445.3 320 456 309.3 456 296C456 282.7 445.3 272 432 272C418.7 272 408 282.7 408 296C408 309.3 418.7 320 432 320zM416 384L416 432C407.2 432 400 439.2 400 448C400 456.8 407.2 464 416 464H448C456.8 464 464 456.8 464 448C464 439.2 456.8 432 448 432V368C448 359.2 440.8 352 432 352H416C407.2 352 400 359.2 400 368C400 376.8 407.2 384 416 384z" />
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_request', '_NOInfo') ?>
                        </div>
                    <?php else : ?>
                        <picture>
                            <source srcset="/app/modules/module_page_request/assets/img/info.webp" type="image/webp">
                            <img src="/app/modules/module_page_request/assets/img/info.jpg" alt="" />
                        </picture>
                        <div class="text_recommend">
                            <?= $Translate->get_translate_module_phrase('module_page_request', '_Recommendations') ?>
                        </div>
                        <div class="requests_rec_block scroll">
                            <div><?php if (!empty($requests[$request_id]['text'])) echo str_replace("\n", "</div><div>", $requests[$request_id]['text']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>