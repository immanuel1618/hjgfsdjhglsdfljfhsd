</div>
<div class="popup_modal" id="popupContacts">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            <?= $Translate->get_translate_phrase('_ContactInfo') ?>
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <hr>
        <div class="contact_body">
            <span><?= $Translate->get_translate_phrase('_ContactRegarding') ?> <a class="contact_mail" href="mailto:<?= $settings_neo['ContactEmail'] ?>&body=Приветствую?subject=У меня есть вопрос"><?= !empty($settings_neo['ContactEmail']) ? $settings_neo['ContactEmail'] : $Translate->get_translate_phrase('_IsHidden'); ?></a></span>
            <hr>
            <span><?= $Translate->get_translate_phrase('_Weareinsocialnetwork') ?></span>
            <div class="social_buttons">
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
            <hr>
            <div class="secondary_btn w100" onclick="location.href='<?= $General->arr_general['site'] ?>request/?id=3'"><?= $Translate->get_translate_phrase('_ContactFeedback') ?></div>
        </div>
    </div>
</div>
<div class="footer_fluid">
    <div class="footer_body">
        <div class="tabbar_mobile">
            <a href="<?= $General->arr_general['site'] ?>" class="<?php if ($Modules->route == 'home') echo 'tabbar_active' ?>">
                <svg x="0" y="0" viewBox="0 0 48 48" xml:space="preserve">
                    <g>
                        <path d="M45.274 14.557A10.049 10.049 0 0 0 29.831 10H18.169a10.049 10.049 0 0 0-15.443 4.557C-.3 22.945-.862 32.048 1.353 36.694A5.5 5.5 0 0 0 4.43 39.75c3.5 1.223 8.086-2.044 12.323-8.75h14.494c3.65 5.778 7.56 9 10.812 9a4.555 4.555 0 0 0 1.511-.252 5.5 5.5 0 0 0 3.077-3.056c2.215-4.644 1.653-13.747-1.373-22.135zM15.5 20.5h-2v2a1.5 1.5 0 0 1-3 0v-2h-2a1.5 1.5 0 0 1 0-3h2v-2a1.5 1.5 0 0 1 3 0v2h2a1.5 1.5 0 0 1 0 3zM26 26h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2zm6.5-5.5A1.5 1.5 0 1 1 34 19a1.5 1.5 0 0 1-1.5 1.5zM36 24a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 36 24zm0-7a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 36 17zm3.5 3.5A1.5 1.5 0 1 1 41 19a1.5 1.5 0 0 1-1.5 1.5z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_phrase('_Sidebar_servers') ?>
            </a>
            <a href="<?= $General->arr_general['site'] ?>store" class="<?php if ($Modules->route == 'store') echo 'tabbar_active' ?>">
                <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M511.52 172.128 482.56 56.224C479.008 41.984 466.208 32 451.52 32H60.512c-14.688 0-27.488 9.984-31.072 24.224L.48 172.128C.16 173.376 0 174.688 0 176c0 44.096 34.08 80 76 80 24.352 0 46.08-12.128 60-30.944C149.92 243.872 171.648 256 196 256s46.08-12.128 60-30.944C269.92 243.872 291.616 256 316 256s46.08-12.128 60-30.944C389.92 243.872 411.616 256 436 256c41.92 0 76-35.904 76-80 0-1.312-.16-2.624-.48-3.872zM436 288c-21.792 0-42.496-6.656-60-18.816-35.008 24.352-84.992 24.352-120 0-35.008 24.352-84.992 24.352-120 0C118.496 281.344 97.792 288 76 288c-15.712 0-30.528-3.68-44-9.952V448c0 17.664 14.336 32 32 32h128V352h128v128h128c17.664 0 32-14.336 32-32V278.048C466.528 284.32 451.712 288 436 288z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_phrase('_SP') ?>
            </a>
            <a href="<?= $General->arr_general['site'] ?>pay" class="<?php if ($Modules->route == 'pay') echo 'tabbar_active' ?>">
                <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="hovered-paths">
                    <g>
                        <path d="M79.002 286.619h45.633v33.683H79.002z" class="hovered-path"></path>
                        <path d="M481.659 197.397H30.341c-16.544 0-29.955 13.411-29.955 29.955v254.694C.386 498.589 13.797 512 30.341 512h451.318c16.544 0 29.955-13.411 29.955-29.955V227.352c0-16.544-13.411-29.955-29.955-29.955zM121.196 447.001H47.054v-29.955h74.142zm33.394-121.706c0 13.764-11.198 24.962-24.962 24.962H74.009c-13.764 0-24.962-11.198-24.962-24.962v-43.668c0-13.764 11.198-24.962 24.962-24.962h55.618c13.764 0 24.962 11.198 24.962 24.962v43.668zm81.189 121.706h-74.142v-29.955h74.142zm114.584 0h-74.142v-29.955h74.142zm114.583 0h-74.142v-29.955h74.142zM402.509 72.766 338.517 8.774c-11.698-11.698-30.664-11.698-42.363 0L137.486 167.442h175.756zM400.669 167.442l46.839-49.677L423.7 93.957l-69.288 73.485zM481.659 167.442c6.434 0 12.63 1.032 18.444 2.918l-31.404-31.404-26.859 28.487h39.819z" class="hovered-path"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_phrase('_Current_balance') ?>
            </a>
            <?php if ($_SESSION['steamid']) : ?>
                <a href="<?= $General->arr_general['site'] ?>profiles/<?= $_SESSION['steamid'] ?>/?search=1" class="<?php if ($Modules->route == 'profiles') echo 'tabbar_active' ?>">
                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                        <g>
                            <path d="M7.25 7c0-2.619 2.131-4.75 4.75-4.75S16.75 4.381 16.75 7s-2.131 4.75-4.75 4.75S7.25 9.619 7.25 7zM15 13.25H9c-3.17 0-5.75 2.58-5.75 5.75A2.752 2.752 0 0 0 6 21.75h12A2.752 2.752 0 0 0 20.75 19c0-3.17-2.58-5.75-5.75-5.75z"></path>
                        </g>
                    </svg>
                    <?= $Translate->get_translate_phrase('_Profile') ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="footer_global">
            <div class="left_footer">
                <div>
                    <a href="<?= $General->arr_general['site'] ?>">
                        <div class="footer_sitename">
                            <?= $settings_neo['SiteName'] ?>
                        </div>
                    </a>
                    <p><?= $General->arr_general['info'] ?></p>
                </div>
            </div>
            <div class="footer_links">
                <ul>
                    <?php if (!empty($settings_neo['SupportLink'])) : ?>
                        <li class="">
                            <a href="<?= $settings_neo['SupportLink'] ?>"><?= $Translate->get_translate_phrase('_Support') ?></a>
                        </li>
                    <?php endif; ?>
                    <li class="">
                        <a href="<?= $General->arr_general['site'] ?>oferta"><?= $Translate->get_translate_phrase('_oferta_sidebar') ?></a>
                    </li>
                    <li class="contact_link" data-openmodal="popupContacts">
                        <a><?= $Translate->get_translate_phrase('_Contacts') ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer_bg"></div>
    </div>
</div>
</div>
<script src="/storage/assets/js/vendors/jquery/jquery-3.5.1.min.js"></script>
<script src="/storage/assets/js/vendors/jquery/jquery-ui.min.js"></script>
<?php if ($Modules->route == 'home') : ?>
    <script src="/app/templates/neo/assets/js/swiper-bundle.min.js"></script>
<?php endif; ?>
<script src="/app/templates/neo/assets/js/popper.min.js"></script>
<script src="/app/templates/neo/assets/js/iziToast.min.js"></script>
<script src="/app/templates/neo/assets/js/clipboard.min.js"></script>
<script src="/app/templates/neo/assets/js/search.js" defer></script>
<script>
    let domain = '<?= $General->arr_general['site'] ?>';
</script>
<?php for ($js = 0, $js_s = sizeof($Modules->js_library); $js < $js_s; $js++) : ?>
    <script src="/<?= $Modules->js_library[$js] ?><?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>"></script>
<?php endfor; ?>
<?php if (!empty($Db->db_data['lk'])) : ?>
    <script src="/app/modules/module_page_pay/assets/js/pay.js<?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>"></script>
<?php endif; ?>
<?php if (!empty($Modules->arr_module_init['page'][$Modules->route]['js'])) :
    for ($js = 0, $js_s = sizeof($Modules->arr_module_init['page'][$Modules->route]['js']); $js < $js_s; $js++) : ?>
        <script src="/app/modules/<?= $Modules->arr_module_init['page'][$Modules->route]['js'][$js]['name'] . '/assets/js/' . $Modules->arr_module_init['page'][$Modules->route]['js'][$js]['type'] . '.js' ?><?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>"></script>
    <?php endfor;
endif; ?>
</body>
</html>