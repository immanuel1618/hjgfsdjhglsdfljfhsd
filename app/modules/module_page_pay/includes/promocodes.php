<?php if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
} ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SettingsPromo') ?></h5>
        </div>
        <div class="card-container">
            <div class="modern_table">
                <div class="mt_header_2">
                    <li>
                        <span style="display: flex; width: 150px; justify-content: flex-start;"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?></span>
                        <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_BonusPromo') ?></span>
                        <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_LimitUsePromo') ?></span>
                        <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_Snap') ?></span>
                        <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                    </li>
                </div>
                <div class="mt_content_2 no-scrollbar">
                    <?php foreach ($LK->LkPromocodes() as $key) : ?>
                        <li>
                            <span style="display: flex; width: 150px; justify-content: flex-start;"><?= $key['code'] ?></span>
                            <span><?= $key['percent'] ?></span>
                            <span><?= $key['attempts'] ?></span>
                            <span><?php if (!empty($key['auth1'])) : print '+';
                                    else : print '-';
                                    endif; ?></span>
                            <span><a href="<?= set_url_section(get_url(2), 'promocode_edit', $key['id']) ?>"><?= $Translate->get_translate_phrase('_Change') ?></a>
                            </span>
                        </li>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Options') ?></h5>
        </div>
        <div class="card-container">
            <a class="secondary_btn" href="<?= set_url_section(get_url(2), 'promocode_add', 'promocodes') ?>"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_AddPromocode') ?></a></option>
        </div>
    </div>
</div>
<?php if (!empty($_GET['promocode_edit'])) : $promo = $LK->LkPromoCode($_GET['promocode_edit']); ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_EditPromo') ?> - <?php echo $promo[0]['code'] ?><a data-del="delete" data-get="promocode_edit" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
            </div>
            <div class="card-container module_block">
                <form id="promocode_edit" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="editid" value="<?php echo $_GET['promocode_edit'] ?>">
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Name') ?>:</div><input name="editpromo" value="<?php echo $promo[0]['code'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_LimitUsePromo') ?>:</div><input name="editlimit" value="<?php echo $promo[0]['attempts'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_BonusPromo') ?>:</div><input name="editbonuspecent" value="<?php echo $promo[0]['percent'] ?>">
                    </div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $promo[0]['auth1'] && print 'checked'; ?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_SnapSID') ?></label>
                    </div>
                </form>
                <div style="display: flex;align-items: center;justify-content: space-between;">
                    <input class="secondary_btn" type="submit" form="promocode_edit" value="<?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Save') ?>">
                    <button class="secondary_btn btn_delete" type="submit" form="promocode_delete"><?php echo $Translate->get_translate_phrase('_Delete_Action') ?></button>
                </div>
                <form data-del="delete" data-get="promocode_edit" id="promocode_delete" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="promocode_delete" value="<?php echo $_GET['promocode_edit'] ?>">
                </form>
                <br>
                <div class="user_pays">
                    <div class="pomo_list no-scrollbar">
                        <?php $usage = $LK->LkUsagePromo($promo[0]['code']);
                        if (!empty($usage)) : ?>
                            <?php foreach ($usage as $key) : ?>
                                <div class="player_promo" onclick="location.href = '<?php echo $General->arr_general['site'] ?>profiles/<?php echo $key['pay_auth'] ?>?search=1'">
                                    <div style="display: flex;width: 100%;justify-content: space-between;">
                                        <span><?php echo action_text_clear(action_text_trim($LK->LkGetUserData($key['pay_auth'])[0]['name'], 16)) ?></span>
                                        <span><?php echo $key['pay_data'] ?></span>
                                    </div>
                                    <img src="/app/modules/module_page_pay/assets/gateways/<?php echo mb_strtolower($key['pay_system']) ?>.svg" alt="">
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php echo $Translate->get_translate_module_phrase('module_page_pay', '_PromoNotUse') ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<?php if (!empty($_GET['promocode_add'])) : ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_AddPromocode') ?><a data-del="delete" data-get="promocode_add" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
            </div>
            <div class="card-container module_block">
                <form id="promocode_add" data-default="true" enctype="multipart/form-data" method="post">
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_AddPromoName') ?></div><input name="addpromo">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_LimitUsePromo') ?>:</div><input name="limit">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_BonusPromo') ?>:</div><input name="bonuspecent">
                    </div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="auth" id="status_add">
                        <label class="border-checkbox-label" for="status_add"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_SnapSID') ?></label>
                    </div>
                </form>
                <input class="secondary_btn" name="promocode_add" type="submit" form="promocode_add" value="<?php echo $Translate->get_translate_module_phrase('module_page_pay', '_AddPromocode') ?>">
            </div>
        </div>
    </div>
<?php endif ?>