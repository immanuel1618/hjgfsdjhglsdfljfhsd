<?php if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$GatewaysArrayList = [
    'freekassa'     => 'FreeKassa MULTI',
    'webmoney'      => 'WebMoney MULTI',
    'yoomoney'      => 'YooMoney',
    'anypay'        => 'AnyPay',
    'paypalych'     => 'PayPalych',
    'cshost'        => 'Cshost',
    'aaio'          => 'Aaio',
    'skinpay'       => 'SkinPay',
    'paypal'        => 'PayPal MULTI'
]; ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SettingsGateways') ?>
                <div class="for_all_time"><?= $Translate->get_translate_module_phrase('module_page_pay', '_BalanceAllTime') ?>: <?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?> <?= $LK->LkAllDonats() ?></div>
            </h5>
        </div>
        <div class="card-container">
            <div class="kassa_block">
                <ul class="kassa_list no-scrollbar">
                    <?php foreach ($LK->LkGetAllGateways() as $key) :
                        $GatewaysExist[mb_strtolower($key['name_kassa'])] = 1; ?>
                        <li class="kassa_line">
                            <div>
                                <?= $key['name_kassa']; ?>
                                <span><?= $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse') ?> <?= $LK->LkAllDonatsToPayGateway(mb_strtolower($key['name_kassa'])); ?></span>
                            </div>
                            <a href="<?= set_url_section(get_url(2), 'geteway_edit', mb_strtolower($key['name_kassa'])) ?>">Настроить</a>
                        </li>
                    <?php endforeach ?>
                </ul>
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
            <div class="select-panel">
                <select style="display: none;" class="custom-select" onChange="window.location.href=this.value" placeholder="<?= $Translate->get_translate_module_phrase('module_page_pay', '_AddGateways') ?>">
                    <?php foreach ($GatewaysArrayList as $url => $name) :
                        if (empty($GatewaysExist[$url])) : ?>
                            <option class="select-options" value="<?= set_url_section(get_url(2), 'gateway_add', $url) ?>">
                                <a href="<?= set_url_section(get_url(2), 'gateway_add', $url) ?>"><?= $name ?> </a>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <form id="webhook_discord" data-default="true" enctype="multipart/form-data" method="post">
                    <div class="input-form">
                        <div class="input_text">Discord Webhook URL:</div><input name="webhoock_url" value="<?php $LK->LkDiscordData()['url'] && print $LK->LkDiscordData()['url']; ?>">
                    </div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="webhoock_url_offon" id="webhoock_url_offon" <?php $LK->LkDiscordData()['auth'] && print 'checked'; ?>>
                        <label class="border-checkbox-label" for="webhoock_url_offon">вкл. / выкл.</label>
                    </div>
                </form>
                <input class="secondary_btn" type="submit" form="webhook_discord" value="<?= $Translate->get_translate_module_phrase('module_page_pay', '_Save') ?>">
            </div>
        </div>
    </div>
</div>
<?php if (!empty($_GET['geteway_edit'])) : $Gateway = $LK->LkGetGateway($_GET['geteway_edit']); ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SetGateways') ?> - <?= ucfirst($_GET['geteway_edit']) ?><a data-del="delete" data-get="geteway_edit" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
            </div>
            <div class="card-container module_block">
                <form id="gateway_edit" data-default="true" enctype="multipart/form-data" method="post">
                    <?php switch ($_GET['geteway_edit']):
                        case 'webmoney': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Purse') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?>:</div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=webmoney
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=webmoney" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'yoomoney': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Purse') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?> ">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=yoomoney
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=yoomoney" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'freekassa': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Password') ?> #1</div><input name="secret1" value="<?= $Gateway[0]['secret_key_1'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Password') ?> #2</div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=freekassa
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=freekassa" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                            <?php break;
                        case 'paypalych': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=paypalych
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=paypalych" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'anypay': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=anypay
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=anypay" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'cshost': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=cshost
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=cshost" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'aaio': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?> #1</div><input name="secret1" value="<?= $Gateway[0]['secret_key_1'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?> #2</div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=aaio
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=aaio" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'skinpay': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text">Public key</div><input name="shopid" value="<?= $Gateway[0]['shop_id'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text">Private key</div><input name="secret2" value="<?= $Gateway[0]['secret_key_2'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=skinpay
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=skinpay" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                        case 'paypal': ?>
                            <input type="hidden" name="gateway_edit" value="<?= $_GET['geteway_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text">Currency (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div><input name="secret2" placeholder="USD">
                            </div>
                            <div class="input-form">
                                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked'; ?>>
                                <label class="border-checkbox-label" for="status"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ActGateways') ?></label>
                            </div>
                        <?php break;
                    endswitch ?>
                </form>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <input class="secondary_btn" type="submit" form="gateway_edit" value="<?= $Translate->get_translate_module_phrase('module_page_pay', '_Save') ?>">
                    <button class="secondary_btn btn_delete" type="submit" form="gateway_delete" title=""><?= $Translate->get_translate_phrase('_Delete_Action') ?></button>
                </div>
                <form data-get="geteway_edit" id="gateway_delete" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="gateway_delete" value="<?= $Gateway[0]['id'] ?>">
                </form>
            </div>
        </div>
    </div>
<?php endif ?>
<?php if (!empty($_GET['gateway_add'])) : ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_AddGateways') ?> - <?= ucfirst($_GET['gateway_add']) ?><a data-del="delete" data-get="gateway_add" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
            </div>
            <div class="card-container module_block">
                <form id="gateway_add" data-default="true" data-get="gateway_add" enctype="multipart/form-data" method="post">
                    <?php switch ($_GET['gateway_add']):
                        case 'webmoney': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Purse') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?>:</div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=webmoney
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=webmoney" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'yoomoney': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Purse') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Password') ?></div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=yoomoney
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=yoomoney" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'freekassa': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Password') ?> #1</div><input name="secret1">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Password') ?> #2</div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=freekassa
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=freekassa" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'paypalych': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=paypalych
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=paypalych" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'anypay': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=anypay
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=anypay" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'cshost': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?></div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=cshost
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=cshost" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'aaio': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?> #1</div><input name="secret1">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_SecretKey') ?> #2</div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=aaio
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=aaio" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'skinpay': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text">Public key</div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text">Private key</div><input name="secret2">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_ResultUrl') ?></div>
                                <div class="no_uppercase_url">
                                    <?= $LK->https() . get_url(2) ?>?gateway=skinpay
                                    <svg data-clipboard-text="<?= $LK->https() . get_url(2) ?>?gateway=skinpay" class="copyurl" data-tippy-content="<?= $Translate->get_translate_phrase('_Copytext') ?>" data-tippy-placement="left" width="16" height="16" viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php break;
                        case 'paypal': ?>
                            <input type="hidden" name="gateway" value="<?= $_GET['gateway_add'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_pay', '_Indetificator') ?></div><input name="shopid">
                            </div>
                            <div class="input-form">
                                <div class="input_text">Currency (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div><input name="secret2" placeholder="USD">
                            </div>
                        <?php break;
                    endswitch ?>
                </form>
                <input class="secondary_btn" name="gateway_save" type="submit" form="gateway_add" value="<?= $Translate->get_translate_module_phrase('module_page_pay', '_AddGateways') ?>">
            </div>
        </div>
    </div>
<?php endif ?>