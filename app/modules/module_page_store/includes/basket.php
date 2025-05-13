<?php
!isset($_SESSION['steamid32']) && get_iframe('013', 'Для доступа необходима авторизация');
$basket = $Basket->findBySteam($_SESSION['steamid32']);
?>

<div class="row shop_bk">
    <div class="col-md-9">
        <div class="shop_back_button" onclick="history.back();return false;">
            <svg viewBox="0 0 256 512">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
            </svg>
            <?= $Translate->get_translate_module_phrase('module_page_store', '_Back') ?>
        </div>
        <div class="card-header">
            <div class="badge" style="justify-content: center;">
                <?= $Translate->get_translate_module_phrase('module_page_store', '_shopBasket') ?>
            </div>
        </div>
        <div class="card-container mobile_cart mobile_cart2">
            <div class="basket_table_content">
                <div class="shop_cart_table_head">
                    <span><?= $Translate->get_translate_module_phrase('module_page_store', '_shopServer') ?></span>
                    <span><?= $Translate->get_translate_module_phrase('module_page_store', '_shopProduct') ?></span>
                    <span></span>
                </div>
                <ul class="shop_cart_table_body">
                    <?php if (empty($basket['basket'])) : ?>
                        <div class="shop_basket_empty">
                            <div class="title_empty">Корзина пуста!</div>
                            <div class="desc_empty">Добавьте понравившиеся вам привилегии в корзину и продолжайте покупки</div>
                            <img src="<?= $General->arr_general['site'] ?>app/modules/module_page_store/assets/img/empty_basket.png" alt="">
                        </div>
                    <?php else: ?>
                        <?php foreach (($basket['basket'] ?? []) as $item) : ?>
                            <li class="shop_basket_item shop_basket_item_<?= $item['id'] ?>">
                                <span><?= $item['server_name']; ?></span>
                                <span><?= $item['title']; ?></span>
                                <span class="shop_basket_delete" onclick="sendAjax('delete-product-basket', '<?= $item['id']; ?>')">
                                    <svg viewBox="0 0 384 512">
                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                    </svg>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <form id="pay-order" class="col-md-3">
        <div class="card-container mobile_cart mobile_cart3">
            <div class="shop_pay_area">
                <div class="input-form w100" <?= empty($promocodes) ? 'style="display: none;"' : '' ?>>
                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_promo') ?></div>
                    <input type="text" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_promo_vash') ?>" class="formbasket" id="basket_promo" name="promo">
                </div>
                <div class="gift_text"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopVariant') ?></div>
                <div class="unique-toggle-switch">
                    <div class="unique-toggle-option active" data-value="for-self"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopForMyself') ?></div>
                    <div class="unique-toggle-option" data-value="as-gift"><?= $Translate->get_translate_module_phrase('module_page_store', '_shopForGift') ?></div>
                    <div class="unique-slider"></div>
                </div>
                <div class="unique-toggle-input-container input-form">
                    <input form="pay-order" type="text" name="steam" id="basket_steam" class="unique-toggle-input hidden_gift formbasket" placeholder="<?= $Translate->get_translate_module_phrase('module_page_store', '_shopSteamIDGift') ?>">
                </div>
                <div class="input-form w100">
                    <div id="pay-button" class="pay_order" <?php if (!empty($basket['basket'])) : ?>onclick="sendAjax('pay-order')" <?php endif; ?>><?= $Translate->get_translate_module_phrase('module_page_store', '_Buyoform') ?></div>
                </div>
            </div>
        </div>
    </form>
</div>