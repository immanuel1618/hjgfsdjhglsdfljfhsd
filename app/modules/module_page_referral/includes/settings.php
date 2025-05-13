<div class="row">
<div class="col-md-6">
    <div class="card">
        <div class="card-header border-bottom">
            <?= $Translate->get_translate_module_phrase('module_page_referral', '_MainSettings') ?>
        </div>
        <div class="card-container">
            <form id="referral_settings_form" enctype="multipart/form-data" method="post">
                <div class="input-flex">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_DiscordWebhookNewRef') ?></div>
                        <input name="discord_webhook_new_ref" value="<?php echo $settingsAdmin['discord_webhook_new_ref']; ?>">
                    </div>
                    
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_DiscordWebhookWithdraw') ?></div>
                        <input name="discord_webhook_withdraw" value="<?php echo $settingsAdmin['discord_webhook_withdraw']; ?>">
                    </div>
                </div>
                <div class="input-form">
                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_MinWithdrawalAmount') ?></div>
                    <input name="min_withdrawal_amount" type="number" value="<?php echo $settingsAdmin['min_withdrawal_amount']; ?>">
                </div>
                <div class="input-flex">
                    <div class="input-form ">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_FirstDepositAmount') ?></div>
                        <input name="first_deposit_amount" type="number" value="<?php echo $settingsAdmin['first_deposit_amount']; ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_FirstDepositBonus') ?></div>
                        <input name="first_deposit_bonus" type="number" value="<?php echo $settingsAdmin['first_deposit_bonus']; ?>">
                    </div>
                </div>
                <div class="input-flex">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_PercentageConverting') ?></div>
                        <input name="percentage_converting" min="0" max="100" type="number" value="<?php echo $settingsAdmin['percentage_converting']; ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_CommissionOutput') ?></div>
                        <input name="commission_output" min="0" max="100" type="number" value="<?php echo $settingsAdmin['commission_output']; ?>">
                    </div>
                </div>
                <div class="input-form-settings">
                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_AvailableWithdrawalTypes') ?></div>
                    <div class="withdrawal-types-containers" id="withdrawal-types-container">
                        <?php 
                        $types = explode(',', $settingsAdmin['available_withdrawal_types']);
                        foreach($types as $type): 
                            if(trim($type) !== ''): ?>
                                <div class="withdrawal-type-item">
                                    <input type="text" name="available_withdrawal_types[]" value="<?php echo trim($type); ?>">
                                    <button type="button" class="remove-type-btn">
                                        <svg viewBox="0 0 320 512"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path></svg>
                                    </button>
                                </div>
                            <?php endif; 
                        endforeach; ?>
                    </div>
                    <button type="button" id="add-withdrawal-type" class="secondary_btn w100 mt10"><?= $Translate->get_translate_module_phrase('module_page_referral', '_AddWithdrawalType') ?></button>
                    <input type="hidden" id="original_withdrawal_types" name="available_withdrawal_types" value="<?php echo $settingsAdmin['available_withdrawal_types']; ?>">
                </div>
                
                <div class="input-form">
                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalType') ?></div>
                    <div class="input_checked_buttons">
                        <div class="radio">
                            <input name="withdrawal_switch_type" type="radio" id="withdrawal_switch_type0" value="0" <?= $settingsAdmin['withdrawal_switch_type'] == 0 ? 'checked' : ''; ?>>
                            <label class="custom-radio" for="withdrawal_switch_type0"><?= $Translate->get_translate_module_phrase('module_page_referral', '_All') ?></label>
                        </div>
                        <div class="radio">
                            <input name="withdrawal_switch_type" type="radio" id="withdrawal_switch_type1" value="1" <?= $settingsAdmin['withdrawal_switch_type'] == 1 ? 'checked' : ''; ?>>
                            <label class="custom-radio" for="withdrawal_switch_type1"><?= $Translate->get_translate_module_phrase('module_page_referral', '_OnlyCard') ?></label>
                        </div>
                        <div class="radio">
                            <input name="withdrawal_switch_type" type="radio" id="withdrawal_switch_type2" value="2" <?= $settingsAdmin['withdrawal_switch_type'] == 2 ? 'checked' : ''; ?>>
                            <label class="custom-radio" for="withdrawal_switch_type2"><?= $Translate->get_translate_module_phrase('module_page_referral', '_OnlySite') ?></label>
                        </div>
                    </div>
                </div>
            </form>
            <input class="secondary_btn w100 mt10" name="referral_settings_form" type="submit" form="referral_settings_form" value="<?= $Translate->get_translate_module_phrase('module_page_referral', '_Save') ?>">
            <?php if(!$tablesExist): ?>
                <button class="secondary_btn w100 mt10" id="ref-create-table">Создать таблицы</button>
            <?php endif; ?>
        </div>
    </div>
</div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-bottom">
                <?= $Translate->get_translate_module_phrase('module_page_referral', '_LevelSettings') ?>
            </div>
            <div class="card-container">
                <form id="referral_settings_lvl_form" enctype="multipart/form-data" method="post">
                    <div class="custom_flex_inputs">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level1Requirement') ?></div>
                            <input name="level1_requirement" type="number" value="<?php echo $settingsAdmin['level1_requirement']; ?>">
                        </div>

                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level1Bonus') ?></div>
                            <input name="level1_bonus" type="number" value="<?php echo $settingsAdmin['level1_bonus']; ?>">
                        </div>
                    </div>
                    <div class="custom_flex_inputs">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level2Requirement') ?></div>
                            <input name="level2_requirement" type="number" value="<?php echo $settingsAdmin['level2_requirement']; ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level2Bonus') ?></div>
                            <input name="level2_bonus" type="number" value="<?php echo $settingsAdmin['level2_bonus']; ?>">
                        </div>
                    </div>
                    <div class="custom_flex_inputs">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level3Requirement') ?></div>
                            <input name="level3_requirement" type="number" value="<?php echo $settingsAdmin['level3_requirement']; ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level3Bonus') ?></div>
                            <input name="level3_bonus" type="number" value="<?php echo $settingsAdmin['level3_bonus']; ?>">
                        </div>
                    </div>
                    <div class="custom_flex_inputs">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level4Requirement') ?></div>
                            <input name="level4_requirement" type="number" value="<?php echo $settingsAdmin['level4_requirement']; ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level4Bonus') ?></div>
                            <input name="level4_bonus" type="number" value="<?php echo $settingsAdmin['level4_bonus']; ?>">
                        </div>
                    </div>
                    <div class="custom_flex_inputs">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level5Requirement') ?></div>
                            <input name="level5_requirement" type="number" value="<?php echo $settingsAdmin['level5_requirement']; ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Level5Bonus') ?></div>
                            <input name="level5_bonus" type="number" value="<?php echo $settingsAdmin['level5_bonus']; ?>">
                        </div>
                    </div>
                </form>
                <input class="secondary_btn w100 mt10" name="referral_settings_lvl_form" type="submit" form="referral_settings_lvl_form" value="<?= $Translate->get_translate_module_phrase('module_page_referral', '_Save') ?>">
            </div>
        </div>
    </div>
</div>