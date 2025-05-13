<div class="row">
    <div class="col-md-12">
        <div class="error_content">
            <img src="<?= $General->arr_general['site'] ?>storage/cache/img/error/search_ava.png" alt="">
            <div class="error_texts_block">
                <div class="error_oops">
                    <div href="#" onclick="history.back();return false;" class="error_arrow">
                        <svg viewBox="0 0 320 512">
                            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                        </svg>
                    </div>
                    <?= $Translate->get_translate_phrase('_ErrorOops') ?>
                </div>
                <div class="error_code"><?= htmlentities($_SESSION["iframe_code"]) ?></div>
                <hr>
                <div class="description"><?= htmlentities($_SESSION["iframe_description"]) ?></div>
                <hr>
                <div class="errors_buttons">
                    <div class="secondary_btn w100" href="#" onclick="window.top.location.href = 'https://'+location.hostname"><?= $Translate->get_translate_phrase('_Home') ?></div>
                    <div class="error_shop_btn secondary_btn w100" href="#" onclick="window.top.location.href = 'https://' + location.hostname + '/store'"><?= $Translate->get_translate_phrase('_SP') ?></div>
                </div>
            </div>
        </div>
        <div class="area">
            <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
</div>