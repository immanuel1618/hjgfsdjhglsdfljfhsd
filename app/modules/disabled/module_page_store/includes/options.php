<?php if (isset($_SESSION['user_admin'])) : ?>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_store', '_discount_shop') ?></div>
            </div>
            <div class="card-container">
                <form id="discount">
                    <div class="input-form">
                        <label for="value_discount" class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_store', '_shopChooseSale') ?></label>
                        <input type="text" id="value_discount" name="value" value="<?php echo $Shop->getDiscount()['discount'] ?>" class="input_promo">
                    </div>
                    <div class="secondary_btn add_discount" onclick="sendAjax('discount', '')">
                        <?php echo $Translate->get_translate_module_phrase('module_page_store', '_shopSetSale') ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="badge">WebHook</div>
            </div>
            <div class="card-container">
                <form id="webhook">
                    <div class="input-form">
                        <label for="value_webhook" class="input_text">WebHook URL</label>
                        <input type="text" id="value_webhook" name="value" value="<?php echo $Shop->getDiscount()['webhook'] ?>" class="input_promo">
                    </div>
                    <div class="secondary_btn add_discount" onclick="sendAjax('webhook', '')">
                        Установить WebHook
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="badge">WebHook</div>
            </div>
            <div class="card-container">
                <form id="webhookcolor">
                    <div class="input-form">
                        <label for="value_webhookcolor" class="input_text">Цвет WebHook</label>
                        <input type="text" id="value_webhookcolor" name="value" value="<?php echo $Shop->getDiscount()['webhookcolor'] ?>" class="input_promo">
                    </div>
                    <div class="secondary_btn add_discount" onclick="sendAjax('webhookcolor', '')">
                        Установить цвет WebHook
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>