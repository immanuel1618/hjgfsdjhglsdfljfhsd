<?php
if (isset($_SESSION['user_admin'])) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="admin_nav">
                <button class="secondary_btn <?php get_section('section', 'store') == 'store' && print 'active_btn_adm' ?>" onclick="location.href = '/store'">
                    <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M2.837 20.977 1.012 9.115c-.135-.876.863-1.474 1.572-.942l5.686 4.264a1.359 1.359 0 0 0 1.945-.333l4.734-7.1c.5-.75 1.602-.75 2.102 0l4.734 7.1a1.359 1.359 0 0 0 1.945.333l5.686-4.264c.71-.532 1.707.066 1.572.942l-1.825 11.862zM27.79 27.559H4.21a1.373 1.373 0 0 1-1.373-1.373v-3.015h26.326v3.015c0 .758-.615 1.373-1.373 1.373z"></path>
                            </g>
                        </g>
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_shopName') ?>
                </button>
                <button class="secondary_btn <?php get_section('section', 'store') == 'options' && print 'active_btn_adm' ?>" onclick="location.href = '?page=store&section=options';">
                    <svg viewBox="0 0 640 512">
                        <path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.7 8.4 166.9 8 160 8s-13.7 .4-20.4 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM208 176c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 400c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_options_shop') ?>
                </button>
            </div>
        </div>
    </div>
<?php }
if (!empty($_GET['section']) && isset($_SESSION['user_admin'])) : ?>
    <div class="row">
        <?php require MODULES . 'module_page_store/includes/' . $_GET['section'] . '.php'; ?>
    </div>
<?php else : ?>
    <div class="row back_shop">
        <div class="shop_product_lines_shadow"></div>
        <div class="col-md-9 shop_product_lines no-scrollbar">
            <?php $flag = 1;
            foreach ($cache as $key => $server) :
                $count = 0;
                foreach ($server as $key_card => $card) :
                    if (is_int($key_card)) :
                        if ($count == 4 || $count == 0) :
                            if ($count == 4)
                                echo "</div>";
                            $count = 0;
                            if ($flag) {
                                echo '<div class="row shop_row_cards shop_server_id_' . $key . '">';
                            } else
                                echo '<div style="display: none" class="row shop_row_cards shop_server_id_' . $key . '">';
                        endif;
                        $count += 1;
            ?>
                        <div class="shop_card_wrapper shop_card_<?= $key . "_" . $key_card; ?>">
                            <div class="shop_card">
                                <div class="shop_card_image">
                                    <?php if (isset($_SESSION['user_admin'])) : ?>
                                        <form id="delete-product">
                                            <div class="shop_delete_card" onclick="sendAjax('delete-product', '<?= $key . ' ' . $key_card ?>')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopDeleteCart') ?></div>
                                        </form>
                                        <div class="shop_change_card" onclick="sendAjax('edit-ajax-product', '<?= $key . ' ' . $key_card ?>')"><?= $Translate->get_translate_phrase('_Change') ?></div>
                                    <?php endif; ?>
                                    <img src="<?= $General->arr_general['site'] ?><?= MODULES; ?>module_page_store/assets/img/<?= $card['image']; ?>">
                                </div>
                                <div class="shop_card_title"><?= $card['title']; ?></div>
                                <div class="shop_card_description no-scrollbar">
                                    <div class="stroke_dc">
                                        <?= str_replace("\n", '</div><div class="stroke_dc">', '' . $card['description']); ?>
                                    </div>
                                </div>
                                <div class="shop_footer_cart">
                                    <div class="price_abs_block">
                                        <div class="price_text">
                                            <?= $Translate->get_translate_module_phrase('module_page_store', '_shopTheCost') ?>
                                        </div>
                                        <div class="shop_card_price">
                                            <?php if ($discount == 0) : echo $card['price'] . " " . $card['value'];
                                            else : ?><div class="sctrike_price"><?= $card['price'] . " " . $card['value'] ?></div>
                                                <?= ceil($card['price'] - $card['price'] * $discount / 100) . " " . $card['value'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <form id="add_product_cart" class="secondary_btn w100" onclick="sendAjax('add-product-cart', '<?= $key . ' ' . $key_card; ?>')">
                                        <?= $Translate->get_translate_module_phrase('module_page_store', '_shopAddToBasket') ?>
                                    </form>
                                </div>
                            </div>
                        </div>
            <?php endif;
                endforeach;
                $flag = 0;
                if ($count > 0) echo "</div>";
            endforeach; ?>
            <?php if (!empty($cache) && isset($_SESSION['user_admin'])) : ?>
                <div class="row shop_row_cards shop_row_add_server" style="margin-top: 20px; margin-bottom: 0 !important;">
                    <div class="secondary_btn shop_card_wrapper shop_add_card" onclick="showShopTable('shop_table_add_card')">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_shopDbvtProd') ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <div class="shop_servers_cart">
                <?php if (isset($_SESSION['user_admin'])) : ?>
                    <div class="shop_action_servers">
                        <span class="secondary_btn" onclick="showShopTable('shop_table_add_server')"><?= $Translate->get_translate_module_phrase('module_page_store', '_addingServer') ?></span>
                    </div>
                <?php endif; ?>
                <div class="shop_servers_column">
                    <?php $serverActive = 1;
                    foreach ($cache as $key => $server) : ?>
                        <div onclick="showCatalog(<?php echo $key ?>, this)" data-value="<?php echo $key; ?>" class="secondary_btn shop_server <?php if ($serverActive) echo 'shop_server_active';
                                                                                                                                                $serverActive = 0; ?>">
                            <?php if (isset($_SESSION['user_admin'])) : ?>
                                <form id="delete-server">
                                    <div class="shop_delete_server" onclick="sendAjax('delete-server', '<?php echo $key; ?>')">
                                        <svg viewBox="0 0 384 512">
                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                        </svg>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <p><?php echo $server['name']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="cart_breadcrump">
                    <div class="cart_left_elements"><?= $Translate->get_translate_module_phrase('module_page_store', '_shoptheCart') ?>
                        <span class="circle_basket">
                            <?php if (array_key_exists($_SESSION['steamid32'], $cart)) echo sizeof($cart[$_SESSION['steamid32']]);
                            else echo 0; ?>
                        </span>
                    </div>
                    <div class="cart_sale">
                        <?php if ($discount ?? 0 + $discount[-1] > 0) : ?>
                            <?= $Translate->get_translate_module_phrase('module_page_store', '_discount_shop') ?> -<?php echo $discount ?>%
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['steamid32'])) : ?>
                    <div class="gift_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopVariant') ?></div>
                    <div class="unique-toggle-switch">
                        <div class="unique-toggle-option active" data-value="for-self"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopForMyself') ?></div>
                        <div class="unique-toggle-option" data-value="as-gift"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopForGift') ?></div>
                        <div class="unique-slider"></div>
                    </div>
                    <div class="unique-toggle-input-container input-form">
                        <input form="pay-product" type="text" name="steam" class="unique-toggle-input hidden_gift" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_shopSteamIDGift') ?>">
                    </div>
                    <hr>
                    <div class="basket">
                        <div class="basket_body">
                            <div class="product_wrapper_cart no-scrollbar" style="<?php if (empty($cart[$_SESSION['steamid32']])) echo "display:none"; ?>">
                                <?php $sumPrice = 0;
                                $valuePrice = 'руб.';
                                if (array_key_exists($_SESSION['steamid32'], $cart) && !empty($cart[$_SESSION['steamid32']])) : ?>
                                    <?php foreach ($cart[$_SESSION['steamid32']] as $key => $value) : $sumPrice += ceil($value['price'] * $value['count'] - $value['price'] * $value['count'] * $discount / 100);
                                        $valuePrice = $value['value']; ?>
                                        <div class="product product_user_<?= $key ?>">
                                            <div class="product_leftinfo">
                                                <div class="product_name"><?= $value['title']; ?></div>
                                                <div class="product_price"><?= $value['count'] * ceil($value['price'] - $value['price'] * $discount / 100) . " " . $value['value']; ?></div>
                                            </div>
                                            <form id="clean-basket">
                                                <div class="product_delete" onclick="sendAjax('clean-basket', '<?= $key ?>')">
                                                    <svg viewBox="0 0 320 512">
                                                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                                    </svg>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="basket_empty" style="<?php if (!empty($cart[$_SESSION['steamid32']])) echo "display:none"; ?>">
                                <?= $Translate->get_translate_module_phrase('module_page_store', '_error_cart_is_empty') ?>
                                <svg x="0" y="0" viewBox="0 0 90 90" xml:space="preserve">
                                    <g>
                                        <path d="M50.065 35.729c4.385 0 8.703 1.913 12.391 5.438a2.276 2.276 0 0 1 .15 3.28 2.269 2.269 0 0 1-3.281.005c-3.01-2.883-6.172-4.188-9.26-4.188-3.084 0-6.24 1.304-9.25 4.188a2.255 2.255 0 0 1-1.637.646c-2.031-.052-2.979-2.545-1.488-3.932 3.682-3.524 7.995-5.437 12.375-5.437zm9.448-8.949a3.288 3.288 0 0 1 0 6.576 3.283 3.283 0 0 1-3.281-3.285 3.286 3.286 0 0 1 3.281-3.291zm-18.885 0a3.288 3.288 0 0 1 3.281 3.291 3.284 3.284 0 1 1-6.568 0 3.289 3.289 0 0 1 3.287-3.291zM10.237 5.269c-4.422.125-5.125 6.795-.844 7.958l5.582 1.971 6.568 34.245c.787 4.098 2.088 7.807 3.906 10.998 2.672 4.699 7.313 8.167 13.037 8.167h28.426c5.131.093 5.131-8.116 0-8.021H38.487c-4.047-.516-5.725-2.555-7.209-5.544H68.8c3.441 0 5.363-3.056 6.213-6.591l8.207-27.92c.438-4.59-1.994-5.496-6.25-5.496l-53.904.041-1.449-4.428c-.391-1.318-1.391-2.336-2.645-2.69zM40.425 72.697a6.088 6.088 0 0 0 0 12.176c3.359 0 6.078-2.727 6.078-6.09a6.082 6.082 0 0 0-6.078-6.086zM64.663 72.697a6.085 6.085 0 0 0-6.078 6.086c0 3.363 2.725 6.09 6.078 6.09a6.088 6.088 0 0 0 0-12.176z"></path>
                                    </g>
                                </svg>
                            </div>
                            <form id="pay-product" class="container_basket" style="<?php if (!array_key_exists($_SESSION['steamid32'], $cart) || (array_key_exists($_SESSION['steamid32'], $cart) && empty($cart[$_SESSION['steamid32']]))) echo "display:none" ?>">
                                <div class="product_price_sum">
                                    <?= $Translate->get_translate_module_phrase('module_page_store', '_shopTotalPrice') ?>: <p class="product_price_sum_number"><?= $sumPrice . " " . $valuePrice; ?></p>
                                </div>
                                <div class="secondary_btn w100" onclick="showShopTable('shop_table_check_info')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckout') ?></div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="shop_black_screen" style="display: none"></div>

    <!-- Check info modal -->

    <div class="shop_table shop_table_check_info" style="display: none">
        <div class="shop_body_table">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckText') ?></div>
            <div class="bg_content">
                <div class="check_warning"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckWarning') ?></div>
                <div class="check_content">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckCorrect') ?>
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckIfelse') ?>
                    <video class="shop_video" muted autoplay loop src="https://stilcs2.ru/app/modules/module_page_store/assets/img/servers_buttons.mp4"></video>
                    <?php $sumPrice = 0;
                    foreach ($cart[$_SESSION['steamid32']] as $key => $value) {
                        $sumPrice += ceil($value['price'] * $value['count'] - $value['price'] * $value['count'] * $discount / 100);
                    }
                    $valuePrice = $value['value']; ?>
                    <hr>
                    <div class="total_summ_modal"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckPrice') ?> <span class="summ_modal"><?= $sumPrice . " " . $valuePrice; ?></span></div>
                </div>
                <form id="pay-product">
                    <div class="shop_wrapper_table_button">
                        <div class="secondary_btn shop_button_add_server w100" onclick="sendAjax('pay-product', '')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckout') ?></div>
                        <div class="secondary_btn btn_delete shop_button_cancel w100" onclick="hideShopTable('shop_table_check_info')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCheckNo') ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add server -->

    <?php if (isset($_SESSION['user_admin'])) : ?>
        <div class="shop_table shop_table_add_server" style="display: none">
            <div class="shop_body_table">
                <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_addServer') ?></div>
                <div class="bg_content">
                    <form id="add-server">
                        <div class="input-form">
                            <label for="shop_list_servers" class="input_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_takeShopServer') ?>:</label>
                        </div>
                        <div class="select-panel">
                            <select name="add_server" id="shop_list_servers" class="custom-select" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_takeShopServer') ?>">
                                <?php foreach ($serversLR as $server) : ?>
                                    <option value="<?= $server['id'] ?>"><?= $server['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="input-form">
                            <label for="shop_name_server" class="input_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopSrvNm') ?></label>
                            <input type="text" id="shop_name_server" name="shop_custom_name_server" placeholder="Public server">
                        </div>
                        <div class="shop_wrapper_table_button">
                            <div class="secondary_btn shop_button_add_server w100" onclick="sendAjax('add-server', '')"><?= $Translate->get_translate_module_phrase('module_page_store', '_addingServer') ?></div>
                            <div class="secondary_btn btn_delete shop_button_cancel w100" onclick="hideShopTable('shop_table_add_server')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCncl') ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- add product -->

        <div class="shop_table shop_table_add_card" style="display: none;">
            <div class="shop_body_table">
                <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopAddPrvlgs') ?></div>
                <div class="bg_content">
                    <form id="add-product">
                        <div class="input-form">
                            <label for="shop_name_server" class="input_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopChsType') ?></label>
                        </div>
                        <div class="">
                            <select name="type_card" id="type_card" class="custom-select" onchange="viewAdminPoints(this.value)" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_shopNotChoosen') ?>">
                                <option value="0">VIP by Pisex/thesamefabius</option>
                                <option value="1">IksAdmin</option>
                                <option value="2">SHOP Credits</option>
                                <option value="3">LR Expirience</option>
                                <option value="4">RCON Command</option>
                            </select>
                        </div>
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="title_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdNmCart') ?></label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="title_card" name="title_card">
                        </div>
                        <div class="input-form">
                            <label class="view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="description_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdDscCart') ?></label>
                            <textarea class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="description_card" name="description_card"></textarea>
                        </div>
                        <div class="shop_wrapper_name_card">
                            <div class="input-form">
                                <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="price_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdPrcCart') ?><br>
                                    <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopExmplPrice') ?> 1000</div>
                                </label>
                                <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="price_card" name="price_card">
                            </div>
                            <div class="input-form">
                                <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="value_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCourceXd') ?><br>
                                    <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopExmplCource') ?></div>
                                </label>
                                <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="value_card" name="value_card">
                            </div>
                        </div>
                        <div class="shop_wrapper_name_card">
                            <div class="input-form">
                                <label class="input_text view-shop view-shop-0 view-shop-1" for="group_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopGrpName') ?><br>
                                    <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopGrpNameDesc') ?></div>
                                </label>
                                <input type="text" class="view-shop-1 view-shop view-shop-0" id="group_card" name="group_card">
                            </div>
                            <div class="input-form">
                                <label class="input_text view-shop view-shop-0 view-shop-1" for="time_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPrvgTime') ?><br>
                                    <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPrvgTimeDesc') ?></div>
                                </label>
                                <input type="text" class="view-shop-1 view-shop view-shop-0" id="time_card" name="time_card">
                            </div>
                        </div>
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="image_path"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopImage') ?><br>
                                <div style="font-size: 9px;"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopImageDesc') ?></div>
                            </label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="image_path" name="image_path" placeholder="vip.jpg">
                        </div>
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-4" for="rcon_command"><?= $Translate->get_translate_module_phrase('module_page_store', '_rconCommand') ?></label>
                            <input type="text" class="view-shop view-shop-4" id="rcon_command" name="rcon">
                        </div>
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-2 view-shop-3" for="amount_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopEntrCount') ?></label>
                            <input type="text" class="view-shop view-shop-2 view-shop-3" id="amount_card" name="amount_card">
                        </div>
                        <div class="shop_wrapper_table_button">
                            <div class="secondary_btn shop_button_add_server w100" onclick="sendAjax('add-product', $('.shop_server_active').attr('data-value'))"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopDbvtProd') ?></div>
                            <div class="secondary_btn btn_delete shop_button_cancel w100" onclick="hideShopTable('shop_table_add_card')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCncl') ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit product -->

        <div class="shop_table shop_table_edit_card" data-value="0" style="display: none;">
            <div class="shop_body_table">
                <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopChaangeProd') ?></div>
                <form id="edit-product">
                    <div class="input-form">
                        <label for="shop_name_server" class="input_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopChsType') ?></label>
                    </div>
                    <div>
                        <select name="type_edit_card" id="type_card" class="custom-select" onchange="viewAdminPoints(this.value)" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_shopNotChoosen') ?>">
                            <option value="0">VIP by Pisex/thesamefabius</option>
                            <option value="1">IksAdmin</option>
                            <option value="2">SHOP Credits</option>
                            <option value="3">LR Expirience</option>
                            <option value="4">RCON Command</option>
                        </select>
                    </div>
                    <div class="input-form">
                        <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="title_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdNmCart') ?></label>
                        <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="title_edit_card" name="title_edit_card">
                    </div>
                    <div class="input-form">
                        <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="description_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdDscCart') ?></label>
                        <textarea class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="description_edit_card" name="description_edit_card"></textarea>
                    </div>
                    <div class="shop_wrapper_name_card">
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="price_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProdPrcCart') ?><br>
                                <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopExmplPrice') ?> 1000</div>
                            </label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="price_edit_card" name="price_edit_card">
                        </div>
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="value_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCourceXd') ?><br>
                                <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopExmplCource') ?></div>
                            </label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="value_edit_card" name="value_edit_card">
                        </div>
                    </div>
                    <div class="shop_wrapper_name_card">
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1" for="group_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopGrpName') ?><br>
                                <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopGrpNameDesc') ?></div>
                            </label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0" id="group_edit_card" name="group_edit_card">
                        </div class="input-form">
                        <div class="input-form">
                            <label class="input_text view-shop view-shop-0 view-shop-1" for="time_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPrvgTime') ?><br>
                                <div style="font-size:9px"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopPrvgTimeDesc') ?></div>
                            </label>
                            <input type="text" class="view-shop-1 view-shop view-shop-0" id="time_edit_card" name="time_edit_card">
                        </div>
                    </div>
                    <div class="input-form">
                        <label class="input_text view-shop view-shop-0 view-shop-1 view-shop-2 view-shop-3 view-shop-4" for="image_edit_path"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopImage') ?><br>
                            <div style="font-size: 9px;"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopImageDesc') ?></div>
                        </label>
                        <input type="text" class="view-shop-1 view-shop view-shop-0 view-shop-2 view-shop-3 view-shop-4" id="image_edit_path" name="image_edit_path" placeholder="vip.jpg">
                    </div>
                    <div class="input-form">
                        <label class="input_text view-shop view-shop-4" for="rcon_edit_command"><?= $Translate->get_translate_module_phrase('module_page_store', '_rconCommand') ?></label>
                        <input type="text" class="view-shop view-shop-4" id="rcon_edit_command" name="rcon_edit_command">
                    </div>
                    <div class="input-form">
                        <label class="input_text view-shop view-shop-2 view-shop-3" for="amount_edit_card"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopEntrCount') ?></label>
                        <input type="text" class="view-shop view-shop-2 view-shop-3" id="amount_edit_card" name="amount_edit_card">
                    </div>
                    <div class="shop_wrapper_table_button">
                        <div class="secondary_btn shop_button_add_server w100" onclick="sendAjax('edit-product', $('.shop_table_edit_card').attr('data-value'))"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopChaangeProdYes') ?></div>
                        <div class="secondary_btn btn_delete shop_button_cancel w100" onclick="hideShopTable('shop_table_edit_card')"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopCncl') ?></div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>