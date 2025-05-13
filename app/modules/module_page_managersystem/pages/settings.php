<?php $errorFound = false; if($Core->TableSearch()) { $errorFound = true; ?>
    <div class="error_db_container">
        <div class="error_db_card">
            <div class="error_text_flex">
                <span class="error_text"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTableAddPls') ?></span>
                <svg viewBox="0 0 512 512"><path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zm240 80c0-8.8 7.2-16 16-16c45 0 85.6 20.5 115.7 53.1c6 6.5 5.6 16.6-.9 22.6s-16.6 5.6-22.6-.9c-25-27.1-57.4-42.9-92.3-42.9c-8.8 0-16-7.2-16-16zm-80 80c-26.5 0-48-21-48-47c0-20 28.6-60.4 41.6-77.7c3.2-4.4 9.6-4.4 12.8 0C179.6 308.6 208 349 208 369c0 26-21.5 47-48 47zM367.6 208a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zm-192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                <form id="ms_settings_add_table">
                    <button class="btn w100"><svg viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateTable') ?></button>
                </form>
            </div>
        </div>
    </div>
<?php } if (!$errorFound) : ?>
<div class="container_settings">
    <div class="container_settings_2">
        <div class="container_flex">
            <form id="ms_settings_general">
                <div class="container_text_settings">
                    <svg viewBox="0 0 576 512"><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOsnovaSetting') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSObazFunc') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <div class="h400 scroll">
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    Webhook URL:
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCanalRedWeb') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="webhookurl" placeholder="https://discord.com/api/webhooks/.../..." value="<?= $Core->GetCache('settings')['webhookurl'] ?>">
                            </div>
                        </div>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    BlockDB Api Key:
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="Введите сюда Api ключ, который вам выдал разработчик" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="blockdbapikey" placeholder="Zqk14jNj3J8CeoPCBVuxY..." value="<?= $Core->GetCache('settings')['blockdbapikey'] ?>">
                            </div>
                        </div>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettingBanAllFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettingBanAll') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="add_punishment_all" id="add_punishment_all1" value="1" <?php if($Core->GetCache('settings')['add_punishment_all'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="add_punishment_all1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="add_punishment_all" id="add_punishment_all0" value="0" <?php if($Core->GetCache('settings')['add_punishment_all'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="add_punishment_all0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($Db->db_data['Vips'])) : ?>
                            <div class="card_settings_flex">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings2') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings1') ?>
                                    </div>
                                </div>
                                <div class="card_button_flex">
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="vip_one_table" id="vip_one_table1" value="1" <?php if($Core->GetCache('settings')['vip_one_table'] == 1) : ?> checked <?php endif; ?>>
                                        <label for="vip_one_table1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                    </div>
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="vip_one_table" id="vip_one_table0" value="0" <?php if($Core->GetCache('settings')['vip_one_table'] == 0) : ?> checked <?php endif; ?>>
                                        <label for="vip_one_table0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFuncIkupAdmin') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIkupAdmin') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="restriction_flag_z" id="restriction_flag_z1" value="1" <?php if($Core->GetCache('settings')['restriction_flag_z'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="restriction_flag_z1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="restriction_flag_z" id="restriction_flag_z0" value="0" <?php if($Core->GetCache('settings')['restriction_flag_z'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="restriction_flag_z0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFuncInkuAccess') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInkuAccess') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="restriction_access" id="restriction_access1" value="1" <?php if($Core->GetCache('settings')['restriction_access'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="restriction_access1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="restriction_access" id="restriction_access0" value="0" <?php if($Core->GetCache('settings')['restriction_access'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="restriction_access0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if ($Core->GetCache('settings')['group_choice_admin'] == 0) : ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFuncDangerFlags') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDangerFlags') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="dangerous_flags" id="dangerous_flags1" value="1" <?php if($Core->GetCache('settings')['dangerous_flags'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="dangerous_flags1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="dangerous_flags" id="dangerous_flags0" value="0" <?php if($Core->GetCache('settings')['dangerous_flags'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="dangerous_flags0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings4') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings3') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="warn_auto_del" id="warn_auto_del1" value="1" <?php if($Core->GetCache('settings')['warn_auto_del'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="warn_auto_del1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="warn_auto_del" id="warn_auto_del0" value="0" <?php if($Core->GetCache('settings')['warn_auto_del'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="warn_auto_del0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSave') ?>">
                </div>
            </form>
        </div>
        <div class="container_flex">
            <form id="ms_settings_general_additional">
                <div class="container_text_settings">
                    <svg viewBox="0 0 576 512"><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDopSettimgs') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFuncYdob') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <div class="h400 scroll">
                        <?php if (!empty($Core->GetCache('settings')['webhookurl'])) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSColor') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSColorHex') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="colorwebhook" placeholder="#ffffff" value="<?= $Core->GetCache('settings')['colorwebhook'] ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($Core->GetCache('settings')['webhookurl'])) : ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSURLImg') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLinkPhoto') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="urlimgwebhook" placeholder="https://site.com/img/1.png" value="<?= $Core->GetCache('settings')['urlimgwebhook'] ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings5') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings6') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="count_warn" placeholder="3" value="<?= $Core->GetCache('settings')['count_warn'] ?>">
                            </div>
                        </div>
                        <?php if (!empty($Db->db_data['Vips'])) : ?>
                            <div class="input_container">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings7') ?>
                                    </div>
                                </div>
                                <div class="input_wrapper">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings8') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="group_test" placeholder="VIPTEST" value="<?= $Core->GetCache('settings')['group_test'] ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateGroupAdminFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateGroupAdmin') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice_admin1" value="1" <?php if($Core->GetCache('settings')['group_choice_admin'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="group_choice_admin1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="group_choice_admin" id="group_choice_admin0" value="0" <?php if($Core->GetCache('settings')['group_choice_admin'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="group_choice_admin0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($Db->db_data['Vips'])) : ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateGroupVipFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateGroupVip') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="group_choice_vip" id="group_choice_vip1" value="1" <?php if($Core->GetCache('settings')['group_choice_vip'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="group_choice_vip1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="group_choice_vip" id="group_choice_vip0" value="0" <?php if($Core->GetCache('settings')['group_choice_vip'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="group_choice_vip0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateReasonBanFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateReasonBan') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="reason_ban" id="reason_ban1" value="1" <?php if($Core->GetCache('settings')['reason_ban'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="reason_ban1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="reason_ban" id="reason_ban0" value="0" <?php if($Core->GetCache('settings')['reason_ban'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="reason_ban0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateReasonMuteFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateReasonMute') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="reason_mute" id="reason_mute1" value="1" <?php if($Core->GetCache('settings')['reason_mute'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="reason_mute1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="reason_mute" id="reason_mute0" value="0" <?php if($Core->GetCache('settings')['reason_mute'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="reason_mute0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateTimeNacazFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateTimeNacaz') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="time_choice_punishment" id="time_choice_punishment1" value="1" <?php if($Core->GetCache('settings')['time_choice_punishment'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="time_choice_punishment1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="time_choice_punishment" id="time_choice_punishment0" value="0" <?php if($Core->GetCache('settings')['time_choice_punishment'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="time_choice_punishment0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="card_settings_flex">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateTimePrivFunc') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSCreateTimePriv') ?>
                                </div>
                            </div>
                            <div class="card_button_flex">
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="time_choice_privileges" id="time_choice_privileges1" value="1" <?php if($Core->GetCache('settings')['time_choice_privileges'] == 1) : ?> checked <?php endif; ?>>
                                    <label for="time_choice_privileges1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                </div>
                                <div class="check_button_card">
                                    <input class="radio__input" type="radio" name="time_choice_privileges" id="time_choice_privileges0" value="0" <?php if($Core->GetCache('settings')['time_choice_privileges'] == 0) : ?> checked <?php endif; ?>>
                                    <label for="time_choice_privileges0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if ($Core->GetCache('settings')['group_choice_admin'] == 1 && $res_system[$server_group]['admin_mod'] == 'IksAdmin' && !empty($Db->db_data['Vips'])) : ?>
                            <div class="card_settings_flex">
                                <div class="input_form">
                                    <div class="input_text">
                                        <svg data-tippy-placement="top" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings10') ?>" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings9') ?> (В следующем обновлении)
                                    </div>
                                </div>
                                <div class="card_button_flex">
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="group_unification" id="group_unification1" value="1" <?php if($Core->GetCache('settings')['group_unification'] == 1) : ?> checked <?php endif; ?>>
                                        <label for="group_unification1" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOn') ?></label>
                                    </div>
                                    <div class="check_button_card">
                                        <input class="radio__input" type="radio" name="group_unification" id="group_unification0" value="0" <?php if($Core->GetCache('settings')['group_unification'] == 0) : ?> checked <?php endif; ?>>
                                        <label for="group_unification0" class="custom-radio"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOff') ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSave') ?>">
                </div>
            </form>
        </div>
    </div>
    <?php if (($res_system[$server_group]['admin_mod'] == 'IksAdmin' || $res_system[$server_group]['admin_mod'] == 'AdminSystem') && !empty($Db->db_data['Vips']) && $Core->GetCache('settings')['vip_one_table'] == 1) : ?><div class="container_settings_2"><?php endif; ?>
            <div class="container_flex">
                <div class="container_text_settings_2">
                    <svg viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddServersss') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServer') ?></span>
                    </div>
                </div>
                <div class="card_servers">
                    <?php foreach ($Core->GetCache('serversiks') as $key) : ?>
                        <div class="card_server">
                            <div>
                                <h5><?= $key['server_name'] ?></h5>
                                <p>ID: <?= $key['server_id'] ?></p>
                            </div>
                            <button id="ms_server_del" id_del="<?= $key['id'] ?>">✖</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form id="ms_settings_servers">
                    <div class="card_settings">
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServer') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameServer') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="server_name" placeholder="#1 → MIRAGE | RED" required>
                            </div>
                        </div>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput2') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="server_id" placeholder="1" required>
                            </div>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerAddBtn') ?>">
                    </div>                 
                </form>
            </div>
        <?php if (!empty($Db->db_data['Vips']) && $Core->GetCache('settings')['vip_one_table'] == 1) : ?>
            <div class="container_flex">
                <div class="container_text_settings_2">
                    <svg viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings11') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings12') ?></span>
                    </div>
                </div>
                <div class="card_servers">
                    <?php foreach ($Core->GetCache('serversvip') as $key) : ?>
                        <div class="card_server">
                            <div>
                                <h5><?= $key['server_name'] ?></h5>
                                <p>ID: <?= $key['server_id'] ?></p>
                            </div>
                            <button id="ms_server_vip_del" id_del="<?= $key['id'] ?>">✖</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form id="ms_settings_servers_vip">
                    <div class="card_settings">
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServer') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameServer') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="server_name" placeholder="#1 → MIRAGE | RED" required>
                            </div>
                        </div>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIDServerInput2') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="server_id" placeholder="1" required>
                            </div>
                        </div>
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSServerAddBtn') ?>">
                    </div>                 
                </form>
            </div>
        <?php endif; ?>       
    <?php if ($res_system[$server_group]['admin_mod'] == 'IksAdmin' && !empty($Db->db_data['Vips']) && $Core->GetCache('settings')['vip_one_table'] == 1) : ?></div></div><?php endif; ?>
</div>
<?php endif; ?>