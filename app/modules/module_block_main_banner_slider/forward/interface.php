<?php $sliders = $Modules->get_settings_modules('module_block_main_banner_slider', 'settings'); ?>
<div class="row">
    <div class="col-md-9">
        <div class="image-slider swiper">
            <div class="image-slider__wrapper swiper-wrapper">
                <?php foreach ($sliders['slides'] as $key) : ?>
                    <div class="image-slider__slide swiper-slide">
                        <div class="image-slider__image">
                            <p data-swiper-parallax="-100" data-swiper-parallax-duration="800"><?= $key['description'] ?></p>
                            <h3 data-swiper-parallax="-200" data-swiper-parallax-duration="800"><?= $key['title'] ?></h3>
                            <?php if (!empty($key['button_url'])) : ?>
                                <div data-swiper-parallax-y="-40" data-swiper-parallax-opacity="0.5" class="swiper_btn" onclick="window.open('<?= $key['button_url'] ?>','_blank')">
                                    <?= $key['button_text'] ?>
                                    <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                        <g>
                                            <path d="M512 40v432a40 40 0 0 1-80 0V136.568L68.284 500.285a40 40 0 0 1-56.569-56.569L375.432 80H40a40 40 0 0 1 0-80h432a40 40 0 0 1 40 40z"></path>
                                        </g>
                                    </svg>
                                    <div class="swiper_action_svg"></div>
                                </div>
                            <?php endif; ?>
                            <img src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_banner_slider/assets/img/<?= $key['img'] ?>" loading="lazy" alt="">
                            <div class="swiper-lazy-preloader"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-buttons"></div>
            <div class="autoplay-progress">
                <svg viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20"></circle>
                </svg>
                <span></span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="right-swiper__block">
            <div class="card right-swiper__sc" href="#" onclick="window.top.location.href = 'https://' + location.hostname + '/skins'">
                <?= $Translate->get_translate_module_phrase('module_block_main_banner_slider', '_set_page_title') ?>
                <img src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_banner_slider/assets/img/sc.png" alt="">
            </div>
            <div class="right-swiper__second">
                <div class="card right-swiper__store" href="#" onclick="window.top.location.href = 'https://' + location.hostname + '/store'">
                    <?= $Translate->get_translate_phrase('_SP') ?>
                    <img src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_banner_slider/assets/img/shop.png" alt="">
                </div>
                <div class="card right-swiper__ds" data-tippy-content="Discord" data-tippy-placement="top" href="#" onclick="window.top.location.href = '<?= $settings_neo['DS'] ?>'">
                    <svg viewBox="0 0 640 512">
                        <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"></path>
                    </svg>
                </div>
            </div>
            <div class="right-swiper__online">
                <div class="card right-swiper__site">
                    <div class="swipe-title__count">На сайте</div>
                    <div class="swipe-count" id="online_site">-</div>
                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                        <g>
                            <path d="M15.54 16.54a1 1 0 0 1-.711-1.7 4.022 4.022 0 0 0 0-5.674 1 1 0 0 1 1.422-1.406 6.021 6.021 0 0 1 0 8.486 1 1 0 0 1-.711.294zm-6.377-.289a1 1 0 0 0 .008-1.414 4.022 4.022 0 0 1 0-5.674 1 1 0 1 0-1.422-1.406 6.021 6.021 0 0 0 0 8.486 1 1 0 0 0 1.414.008zm10.269 2.42a9.949 9.949 0 0 0 0-13.342 1 1 0 0 0-1.483 1.342 7.949 7.949 0 0 1 0 10.658 1 1 0 0 0 1.483 1.342zm-13.452.07a1 1 0 0 0 .071-1.412 7.949 7.949 0 0 1 0-10.658 1 1 0 0 0-1.483-1.342 9.949 9.949 0 0 0 0 13.342 1 1 0 0 0 1.412.07zM12 10.5a1.5 1.5 0 1 0 1.5 1.5 1.5 1.5 0 0 0-1.5-1.5z"></path>
                        </g>
                    </svg>
                </div>
                <div class="card right-swiper__server">
                    <div class="swipe-title__count-server">Играют</div>
                    <div class="swipe-count-server" id="online_server">-</div>
                    <svg x="0" y="0" viewBox="0 0 26 26" xml:space="preserve">
                        <g>
                            <path d="M1.63 20.68c1.047 2.235 3.79 2.946 6.28.79 4.043-3.24 6.026-3.314 10.15-.02 2.586 2.22 5.288 1.391 6.31-.77 1.43-3.02.03-7.93-.57-9.41-1.408-3.586-5.04-4.824-7.99-3.71-.698.275-1.078.51-1.81.64v-.834c0-1.177.958-2.135 2.136-2.135h2.896a1 1 0 1 0 0-2h-2.896A4.14 4.14 0 0 0 12 7.366V8.2c-.725-.128-1.094-.357-1.84-.65-3-1.134-6.583.204-7.96 3.72-.6 1.48-2 6.39-.57 9.41zm18-7.54c.37-.38 1.05-.38 1.42 0 .26.26.38.671.21 1.08-.265.684-1.145.815-1.63.33a1.002 1.002 0 0 1 0-1.41zm-2.5-2.41a1.004 1.004 0 0 1 1.42 0c.416.417.349 1.06 0 1.41-.398.358-.96.416-1.42 0-.346-.345-.416-.996 0-1.41zm0 4.82a.995.995 0 0 1 1.42 0c.378.378.396.991 0 1.41-.402.361-.95.424-1.42 0a1.002 1.002 0 0 1 0-1.41zm-2.5-2.41c.333-.371 1.028-.41 1.41 0 .406.384.39 1.02 0 1.41a.996.996 0 0 1-1.41 0c-.43-.476-.34-1.088 0-1.41zm-8.85-.3h.59v-.58c0-.55.45-1 1-1s1 .45 1 1v.58h.58c.55 0 1 .45 1 1s-.45 1-1 1h-.58v.58c0 .56-.45 1-1 1s-1-.44-1-1v-.58h-.59c-.55 0-1-.45-1-1s.45-1 1-1z"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>