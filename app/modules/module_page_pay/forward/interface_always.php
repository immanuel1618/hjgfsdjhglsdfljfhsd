<div class="popup_modal" id="popupPay">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            <?= $Translate->get_translate_module_phrase('module_page_pay', '_LK') ?>
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <form id="pay" data-default="true" enctype="multipart/form-data" method="post" class="lk_window">
            <div class="popup_balance_content">
                <?php $Gateways = $LK->LkGetGatewaysOn(); if (!empty($Gateways)) : ?>
                    <div class="popub_balance_first">
                        <div class="popup_column">
                            <div class="popup_input-form" style="margin-bottom: 0">
                                <div class="pay_info-text">Если возникли проблемы с пополнением на одном из способов, попробуйте другой способ оплаты, представленный среди списка ниже</div>
                                <div class="input_text">
                                    <svg viewBox="0 0 576 512">
                                        <path d="M512 32C547.3 32 576 60.65 576 96V128H0V96C0 60.65 28.65 32 64 32H512zM576 416C576 451.3 547.3 480 512 480H64C28.65 480 0 451.3 0 416V224H576V416zM112 352C103.2 352 96 359.2 96 368C96 376.8 103.2 384 112 384H176C184.8 384 192 376.8 192 368C192 359.2 184.8 352 176 352H112zM240 384H368C376.8 384 384 376.8 384 368C384 359.2 376.8 352 368 352H240C231.2 352 224 359.2 224 368C224 376.8 231.2 384 240 384z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_pay', '_ChangeGateway') ?>
                                </div>
                                <div class="popup_pay_area">
                                    <?php foreach ($Gateways as $info) : ?>
                                        <input type="radio" name="gatewayPay" data-name="<?= $info['name_kassa']; ?>" value="<?= mb_strtolower($info['name_kassa']) ?>" id="Gateway<?= $info['id'] ?>" class="popup_gateways">
                                        <label for="Gateway<?= $info['id'] ?>" class="popup_gateways-label">
                                            <img src="<?= $General->arr_general['site'] . MODULES ?>module_page_pay/assets/gateways/<?= mb_strtolower($info['name_kassa']) ?>.svg" alt="">
                                        </label>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['steamid32'])) : ?>
                                <input type="hidden" name="steam" value="<?= $_SESSION['steamid32'] ?>">
                            <?php else : ?>
                                <div class="popup_input-form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 496 512">
                                            <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                                        </svg>
                                        STEAM ID:
                                    </div>
                                    <input name="steam" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/... ">
                                </div>
                            <?php endif ?>
                            <div class="popup_input-form" id="promoresult"></div>
                            <?php if (isset($hasPayment) && $hasPayment === 1) : ?>
                            <div class="popup_input-form">
                            <div class="promoresult_st">Вы получите <span class="amount_st"><?= $hasBouns['first_deposit_bonus'] ?>₽</span> на баланс при пополнении от <?= $hasBouns['first_deposit_amount'] ?>₽!<br>За первое пополнение с реферальным кодом!</div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="popup_middle_line">
                        <span class="popup_line_top"></span>
                        <span class="popup_arrow"></span>
                        <span class="popup_line_bottom"></span>
                    </div>
                <?php endif; ?>
                <div class="popub_balance_second">
                    <div style="width: 100% !important;display: flex;flex-direction: column;">
                        <div class="popup_input-form w100">
                            <div class="input_text">
                                <svg x="0" y="0" viewBox="0 0 25 24" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M19.972 8.75h-2.94c-1.27 0-2.03-.76-2.03-2.03V3.78c0-1.27.76-2.03 2.03-2.03h2.94c1.27 0 2.03.76 2.03 2.03v2.94c0 1.27-.76 2.03-2.03 2.03zm.22-3.31c-.12-.12-.28-.18-.44-.18s-.32.06-.44.18l-.18.18V3.38c0-.35-.28-.63-.63-.63s-.63.28-.63.63v2.24l-.18-.18c-.24-.24-.64-.24-.88 0s-.24.64 0 .88l1.25 1.25c.05.05.12.09.19.12.02.01.04.01.06.02.05.02.1.03.16.03h.06c.07 0 .13-.01.2-.04h.02c.07-.03.13-.07.18-.12.01-.01.01-.01.02-.01l1.25-1.25c.24-.24.24-.64-.01-.88zM2.002 11.46v5c0 2.29 1.85 4.14 4.14 4.14h11.71c2.29 0 4.15-1.86 4.15-4.15v-4.99c0-.67-.54-1.21-1.21-1.21H3.212c-.67 0-1.21.54-1.21 1.21zm6 5.79h-2c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h2c.41 0 .75.34.75.75s-.34.75-.75.75zm6.5 0h-4c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4c.41 0 .75.34.75.75s-.34.75-.75.75zM13.502 4.61v2.93c0 .67-.54 1.21-1.21 1.21h-9.08c-.68 0-1.21-.56-1.21-1.23.01-1.13.46-2.16 1.21-2.91s1.79-1.21 2.93-1.21h6.15c.67 0 1.21.54 1.21 1.21z"></path>
                                        </g>
                                    </g>
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_pay', '_ChoosenGateway') ?>
                            </div>
                        </div>
                        <div class="popup_pay_info">
                            <div class="popup_pay_info_left">
                                <span class="popup_title_text">Способ оплаты</span>
                                <span class="popup_pay_method" id="kass_name">Не выбран</span>
                            </div>
                            <div id="kass_img"></div>
                        </div>
                        <div class="skintoggle" id="skinnone">
                            <div class="popup_input-form w100">
                                <div class="input_text">
                                    <svg x="0" y="0" viewBox="0 0 25 24" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M19.972 8.75h-2.94c-1.27 0-2.03-.76-2.03-2.03V3.78c0-1.27.76-2.03 2.03-2.03h2.94c1.27 0 2.03.76 2.03 2.03v2.94c0 1.27-.76 2.03-2.03 2.03zm.22-3.31c-.12-.12-.28-.18-.44-.18s-.32.06-.44.18l-.18.18V3.38c0-.35-.28-.63-.63-.63s-.63.28-.63.63v2.24l-.18-.18c-.24-.24-.64-.24-.88 0s-.24.64 0 .88l1.25 1.25c.05.05.12.09.19.12.02.01.04.01.06.02.05.02.1.03.16.03h.06c.07 0 .13-.01.2-.04h.02c.07-.03.13-.07.18-.12.01-.01.01-.01.02-.01l1.25-1.25c.24-.24.24-.64-.01-.88zM2.002 11.46v5c0 2.29 1.85 4.14 4.14 4.14h11.71c2.29 0 4.15-1.86 4.15-4.15v-4.99c0-.67-.54-1.21-1.21-1.21H3.212c-.67 0-1.21.54-1.21 1.21zm6 5.79h-2c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h2c.41 0 .75.34.75.75s-.34.75-.75.75zm6.5 0h-4c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4c.41 0 .75.34.75.75s-.34.75-.75.75zM13.502 4.61v2.93c0 .67-.54 1.21-1.21 1.21h-9.08c-.68 0-1.21-.56-1.21-1.23.01-1.13.46-2.16 1.21-2.91s1.79-1.21 2.93-1.21h6.15c.67 0 1.21.54 1.21 1.21z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_pay', '_GetAmoumtYour') ?>
                                </div>
                            </div>
                            <div class="preset_buttons">
                                <button class="secondary_btn popup_fill_width preset-amount" type="button" data-amount="100">100</button>
                                <button class="secondary_btn popup_fill_width preset-amount" type="button" data-amount="250">250</button>
                                <button class="secondary_btn popup_fill_width preset-amount" type="button" data-amount="500">500</button>
                                <button class="secondary_btn popup_fill_width preset-amount" type="button" data-amount="1000">1000</button>
                                <button class="secondary_btn popup_fill_width preset-amount" type="button" data-amount="2000">2000</button>
                                <button id="clearButton" class="secondary_btn popup_fill_width delete-amount" type="button">
                                    <svg viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.188 3.322c.523-.21 1.1-.266 1.656-.158a2.894 2.894 0 0 1 1.468.762l.908.877 2.994-2.909c.237-.222.554-.344.883-.342.329.003.644.131.876.357.233.226.365.531.368.85a1.2 1.2 0 0 1-.352.858l-2.997 2.906.906.877c.4.39.673.886.784 1.426.11.54.053 1.1-.164 1.608l-.652 1.53-8.252-8.009 1.574-.633ZM4.943 4.63l9.227 8.959-1.448 3.391c-.07.163-.18.307-.32.419a1.12 1.12 0 0 1-1.021.196 1.11 1.11 0 0 1-.46-.269L1.093 7.783a1.042 1.042 0 0 1-.073-1.436c.115-.137.262-.243.43-.311L4.942 4.63ZM17.49 17.243c0 .673.562 1.219 1.255 1.219.693 0 1.255-.546 1.255-1.219 0-.672-.562-1.218-1.255-1.218-.693 0-1.255.546-1.255 1.218Zm-1.673-.407a.824.824 0 0 1-.836-.81c0-.449.374-.812.836-.812.461 0 .835.363.835.811a.824.824 0 0 1-.835.811Zm1.674-3.247c0 .448.374.811.835.811a.824.824 0 0 0 .836-.811.824.824 0 0 0-.836-.812.824.824 0 0 0-.835.812Z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="popup_input-form w100">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M512 80c0 18-14.3 34.6-38.4 48c-29.1 16.1-72.5 27.5-122.3 30.9c-3.7-1.8-7.4-3.5-11.3-5C300.6 137.4 248.2 128 192 128c-8.3 0-16.4 .2-24.5 .6l-1.1-.6C142.3 114.6 128 98 128 80c0-44.2 86-80 192-80S512 35.8 512 80zM160.7 161.1c10.2-.7 20.7-1.1 31.3-1.1c62.2 0 117.4 12.3 152.5 31.4C369.3 204.9 384 221.7 384 240c0 4-.7 7.9-2.1 11.7c-4.6 13.2-17 25.3-35 35.5c0 0 0 0 0 0c-.1 .1-.3 .1-.4 .2l0 0 0 0c-.3 .2-.6 .3-.9 .5c-35 19.4-90.8 32-153.6 32c-59.6 0-112.9-11.3-148.2-29.1c-1.9-.9-3.7-1.9-5.5-2.9C14.3 274.6 0 258 0 240c0-34.8 53.4-64.5 128-75.4c10.5-1.5 21.4-2.7 32.7-3.5zM416 240c0-21.9-10.6-39.9-24.1-53.4c28.3-4.4 54.2-11.4 76.2-20.5c16.3-6.8 31.5-15.2 43.9-25.5V176c0 19.3-16.5 37.1-43.8 50.9c-14.6 7.4-32.4 13.7-52.4 18.5c.1-1.8 .2-3.5 .2-5.3zm-32 96c0 18-14.3 34.6-38.4 48c-1.8 1-3.6 1.9-5.5 2.9C304.9 404.7 251.6 416 192 416c-62.8 0-118.6-12.6-153.6-32C14.3 370.6 0 354 0 336V300.6c12.5 10.3 27.6 18.7 43.9 25.5C83.4 342.6 135.8 352 192 352s108.6-9.4 148.1-25.9c7.8-3.2 15.3-6.9 22.4-10.9c6.1-3.4 11.8-7.2 17.2-11.2c1.5-1.1 2.9-2.3 4.3-3.4V304v5.7V336zm32 0V304 278.1c19-4.2 36.5-9.5 52.1-16c16.3-6.8 31.5-15.2 43.9-25.5V272c0 10.5-5 21-14.9 30.9c-16.3 16.3-45 29.7-81.3 38.4c.1-1.7 .2-3.5 .2-5.3zM192 448c56.2 0 108.6-9.4 148.1-25.9c16.3-6.8 31.5-15.2 43.9-25.5V432c0 44.2-86 80-192 80S0 476.2 0 432V396.6c12.5 10.3 27.6 18.7 43.9 25.5C83.4 438.6 135.8 448 192 448z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_pay', '_ToUpAmount') ?>
                                </div>
                                <div class="popup_number">
                                    <button class="popup_number-minus" type="button" onclick="decrementValue(this);" data-tippy-content="-25" data-tippy-placement="top">-</button>
                                    <input id="numberInput" type="number" min="25" max="10000" value="50" name="amount" placeholder="Введите сумму" onchange="updateValue(this);">
                                    <button class="popup_number-plus" type="button" onclick="incrementValue(this);" data-tippy-content="+25" data-tippy-placement="top">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="popup_promo_block">
                            <div class="popup_input-form w100">
                                <div class="input_text">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M28.038 8.81a.996.996 0 0 0-1.41 0 2.432 2.432 0 1 1-3.44-3.44.996.996 0 0 0 0-1.41l-2.66-2.669c-.19-.18-.45-.29-.71-.29-.27 0-.52.11-.71.29L8.72 11.681l11.59 11.608L30.707 12.89c.39-.39.39-1.02 0-1.42zM1 19.82c0 .26.11.52.29.71l2.67 2.66c.39.39 1.02.39 1.41 0a2.432 2.432 0 1 1 3.44 3.44.996.996 0 0 0 0 1.409l2.66 2.67c.2.19.46.29.71.29.259 0 .509-.1.709-.29l5.3-5.3-11.6-11.599-5.299 5.3c-.18.19-.29.44-.29.71z"></path>
                                        </g>
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?>
                                </div>
                                <div class="popup_promo_area">
                                    <input name="promocode" placeholder="<?= $Translate->get_translate_module_phrase('module_page_pay', '_GetInputPromo') ?>">
                                    <div class="popup_clear_promo" id="popupClearPromo">
                                        <svg viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.188 3.322c.523-.21 1.1-.266 1.656-.158a2.894 2.894 0 0 1 1.468.762l.908.877 2.994-2.909c.237-.222.554-.344.883-.342.329.003.644.131.876.357.233.226.365.531.368.85a1.2 1.2 0 0 1-.352.858l-2.997 2.906.906.877c.4.39.673.886.784 1.426.11.54.053 1.1-.164 1.608l-.652 1.53-8.252-8.009 1.574-.633ZM4.943 4.63l9.227 8.959-1.448 3.391c-.07.163-.18.307-.32.419a1.12 1.12 0 0 1-1.021.196 1.11 1.11 0 0 1-.46-.269L1.093 7.783a1.042 1.042 0 0 1-.073-1.436c.115-.137.262-.243.43-.311L4.942 4.63ZM17.49 17.243c0 .673.562 1.219 1.255 1.219.693 0 1.255-.546 1.255-1.219 0-.672-.562-1.218-1.255-1.218-.693 0-1.255.546-1.255 1.218Zm-1.673-.407a.824.824 0 0 1-.836-.81c0-.449.374-.812.836-.812.461 0 .835.363.835.811a.824.824 0 0 1-.835.811Zm1.674-3.247c0 .448.374.811.835.811a.824.824 0 0 0 .836-.811.824.824 0 0 0-.836-.812.824.824 0 0 0-.835.812Z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="popup_input-form w100">
                                <div class="input_text">
                                    <svg x="0" y="0" viewBox="0 0 263.285 263.285" xml:space="preserve">
                                        <g>
                                            <path d="M193.882 8.561c-7.383-3.756-16.414-.813-20.169 6.573L62.153 234.556c-3.755 7.385-.812 16.414 6.573 20.169a14.94 14.94 0 0 0 6.786 1.632c5.466 0 10.735-2.998 13.383-8.205L200.455 28.73c3.755-7.385.812-16.414-6.573-20.169zM113.778 80.818c0-31.369-25.521-56.89-56.89-56.89C25.521 23.928 0 49.449 0 80.818c0 31.368 25.521 56.889 56.889 56.889 31.369 0 56.889-25.521 56.889-56.889zm-56.889 26.889C42.063 107.707 30 95.644 30 80.818c0-14.827 12.063-26.89 26.889-26.89 14.827 0 26.89 12.062 26.89 26.89-.001 14.826-12.063 26.889-26.89 26.889zM206.396 125.58c-31.369 0-56.89 25.521-56.89 56.889 0 31.368 25.52 56.889 56.89 56.889 31.368 0 56.889-25.52 56.889-56.889 0-31.369-25.52-56.889-56.889-56.889zm0 83.777c-14.827 0-26.89-12.063-26.89-26.889 0-14.826 12.063-26.889 26.89-26.889 14.826 0 26.889 12.063 26.889 26.889 0 14.826-12.062 26.889-26.889 26.889z"></path>
                                        </g>
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_pay', '_CurrentPromo') ?>
                                </div>
                                <div class="popup_promo_list">
                                    <?php foreach ($LK->LkPromocodes() as $key) : ?>
                                        <div class="popup_current_promo popup_copybtn" data-promocode="<?= $key['code'] ?>">
                                            <?= $key['code'] ?>
                                            <svg width="16" height="16" viewBox="0 0 512 512">
                                                <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z" />
                                            </svg>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>

                        <div class="popup_reff_block">
                            <div class="popup_input-form w100">
                                <div class="input_text">
                                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                        <g>
                                            <path d="M28.038 8.81a.996.996 0 0 0-1.41 0 2.432 2.432 0 1 1-3.44-3.44.996.996 0 0 0 0-1.41l-2.66-2.669c-.19-.18-.45-.29-.71-.29-.27 0-.52.11-.71.29L8.72 11.681l11.59 11.608L30.707 12.89c.39-.39.39-1.02 0-1.42zM1 19.82c0 .26.11.52.29.71l2.67 2.66c.39.39 1.02.39 1.41 0a2.432 2.432 0 1 1 3.44 3.44.996.996 0 0 0 0 1.409l2.66 2.67c.2.19.46.29.71.29.259 0 .509-.1.709-.29l5.3-5.3-11.6-11.599-5.299 5.3c-.18.19-.29.44-.29.71z"></path>
                                        </g>
                                    </svg>
                                    Реферальный код
                                </div>
								<?php if (!empty($referral_pays['referral'])): ?>
									<div class="popup_promo_area">
										<input value="<?php echo htmlspecialchars($referral_pays['referral']); ?>" readonly>
										<div class="popup_accept_reff" style="pointer-events: none; opacity: 0.5;">
											<svg width="800px" height="800px" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true"><path d="m 13,4.1974 q 0,0.3097 -0.21677,0.5265 l -5.60517,5.6051 -1.0529,1.0529 q -0.21677,0.2168 -0.52645,0.2168 -0.30968,0 -0.52645,-0.2168 L 4.01935,10.329 1.21677,7.5264 Q 1,7.3097 1,7 1,6.6903 1.21677,6.4735 L 2.26968,5.4206 q 0.21677,-0.2167 0.52645,-0.2167 0.30968,0 0.52645,0.2167 l 2.27613,2.2839 5.07871,-5.0864 q 0.21677,-0.2168 0.52645,-0.2168 0.30968,0 0.52645,0.2168 L 12.78323,3.671 Q 13,3.8877 13,4.1974 z"/></svg>
										</div>
									</div>
								<?php else: ?>
									<div class="popup_promo_area">
										<input name="referral" placeholder="Вставьте реферальный код">
										<div class="popup_accept_reff">
											<svg width="800px" height="800px" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true"><path d="m 13,4.1974 q 0,0.3097 -0.21677,0.5265 l -5.60517,5.6051 -1.0529,1.0529 q -0.21677,0.2168 -0.52645,0.2168 -0.30968,0 -0.52645,-0.2168 L 4.01935,10.329 1.21677,7.5264 Q 1,7.3097 1,7 1,6.6903 1.21677,6.4735 L 2.26968,5.4206 q 0.21677,-0.2167 0.52645,-0.2167 0.30968,0 0.52645,0.2167 l 2.27613,2.2839 5.07871,-5.0864 q 0.21677,-0.2168 0.52645,-0.2168 0.30968,0 0.52645,0.2168 L 12.78323,3.671 Q 13,3.8877 13,4.1974 z"/></svg>
										</div>
									</div>
								<?php endif; ?>
                            </div>
                        </div>
						
                        <hr>
                        <div class="form-group accept">
                            <input id="checkbox" type="checkbox"><label for="checkbox"><?= $Translate->get_translate_module_phrase('module_page_pay', '_AgreeOferta') ?> <a href="<?= $General->arr_general['site'] ?>oferta"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Oferta') ?></a></label>
                        </div>
                        <input id="paybutton" class="popup_btn_purple secondary_btn popup_btn_disabled w100" form="pay" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_pay', '_ButtonPay') ?>" disabled="">
                    </div>
                </div>
            </div>
        </form>
        <div style="display: none;" id="resultForm"></div>
    </div>
</div>